<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Core\Core;
use App\Models\BalanceDetail;
use App\Models\Enum\BalanceDetailEnum;
use App\Models\Enum\OrderEnum;
use App\Models\Order;
use App\Models\User;
use Illuminate\Support\Facades\Log;
use Yansongda\LaravelPay\Facades\Pay;

class VerifyController extends Controller
{
    /**
     * 支付宝异步通知
     * @return mixed
     */
    public function notify()
    {
        $alipay = Pay::alipay();

        try {
            $data = $alipay->verify(); // 是的，验签就这么简单！
            // 订单号：$data->out_trade_no
            // 支付宝交易号：$data->trade_no
            // 订单总金额：$data->total_amount
            // 请自行对 trade_status 进行判断及其它逻辑进行判断，在支付宝的业务通知中，只有交易通知状态为 TRADE_SUCCESS 或 TRADE_FINISHED 时，支付宝才会认定为买家付款成功。
            // 1、商户需要验证该通知数据中的out_trade_no是否为商户系统中创建的订单号
            // 2、判断total_amount是否确实为该订单的实际金额（即商户订单创建时的金额）；
            if ($data->trade_status == 'TRADE_SUCCESS' || $data->trade_status == 'TRADE_FINISHED') {
                $order = Order::where('sn', $data->out_trade_no)->first();
                if (!$order)
                    die;
                if($order->status == OrderEnum::PAYED)
                    die;
                if ($data->total_amount != $order->total)
                    die;
                $order->status = OrderEnum::PAYED;
                $order->save();
                $this->distributor($order->user);
            }
            // 3、校验通知中的seller_id（或者seller_email) 是否为out_trade_no这笔单据的对应的操作方（有的时候，一个商户可能有多个seller_id/seller_email）；
            // 4、验证app_id是否为该商户本身。
            // 5、其它业务逻辑情况

            Log::debug('Alipay notify', $data->all());
        } catch (\Exception $e) {
            Log::debug('Alipay notify error', $e->getMessage());
            return show(Core::HTTP_ERROR_CODE,'非法请求');
        }

        return $alipay->success();// laravel 框架中请直接 `return $alipay->success()`
    }

    /**
     * 微信异步通知
     * @return mixed
     */
    public function wxNotify()
    {
        $pay = Pay::wechat();

        try{
            $data = $pay->verify(); // 是的，验签就这么简单！
            if ($data->result_code == 'SUCCESS' && $data->return_code == 'SUCCESS' && $data->mch_id == config('pay.wechat.mch_id')) {
                $order = Order::where('sn', $data->out_trade_no)->first();
                if (!$order)
                    die;
                if($order->status == OrderEnum::PAYED)
                    die;
                if ($data->total_amount != $order->total)
                    die;
                $order->status = OrderEnum::PAYED;
                $order->save();
                $this->distributor($order->user);
            }
            Log::debug('Wechat notify', $data->all());
        } catch (\Exception $e) {
            Log::debug('Wechat pay notify error', $e->getMessage());
            return show(Core::HTTP_ERROR_CODE,'非法请求');
        }
        return $pay->success();// laravel 框架中请直接 `return $alipay->success()`
    }
    /**
     * @param User $buyer
     */
    public function distributor(User $buyer)
    {
        if(!Core::DISTRIBUTOR_STATUS)
            return;
        $orders = $buyer->orders()->where('status','>=', OrderEnum::PAYED)->get();
        if (count($orders) > 1)
            return;
        if (!$buyer->invite_id)
            return;
        /** @var User $inviter */
        $inviter = $buyer->inviter;
        $underless = $inviter->underless()->count();
        if (!$underless)
            return;
        //一级分销 推荐2人推荐人加 500
        $buyerUnder = $this->getBuyerUnder($inviter->underless);
        if(!count($buyerUnder))
            return;
        if(count($buyerUnder) % 2 != 0)
            return;
        $balanceDetail = new BalanceDetail(['cash' => Core::FIRST_DISTRIBUTOR_MONEY, 'type' => BalanceDetailEnum::FIRST_REWARD_TYPE, 'before_balance' => $inviter->balance, 'after_balance' => $inviter->balance + Core::FIRST_DISTRIBUTOR_MONEY]);
        $inviter->balanceDetails()->save($balanceDetail);
        $inviter->balance += Core::FIRST_DISTRIBUTOR_MONEY;
        $inviter->save();
        //二级分销
        if (!$inviter->invite_id)
            return;
        $topInviter = $inviter->inviter;
        $allUnderless = $topInviter->underless;
        if (count($allUnderless) < Core::SECOND_DISTRIBUTOR_PEOPLE)
            return;
        //记算下下级人数
        $underTeam = [];
        foreach ($allUnderless as $allUnderles) {
            //获取下级的下级购买人数
            $allBuyerUnder = $this->getBuyerUnder($allUnderles->underless);
            if(!$allBuyerUnder)
                continue;
            count($allBuyerUnder) % Core::SECOND_DISTRIBUTOR_PEOPLE == 0 ? $underTeam[] = count($allBuyerUnder) : '';
        }
        if(!$underTeam)
            return;
        if(array_sum($underTeam) % (Core::SECOND_DISTRIBUTOR_PEOPLE * 2) != 0)
            return;
        $balanceDetail = new BalanceDetail(['cash' => Core::SECOND_DISTRIBUTOR_MONEY, 'type' => BalanceDetailEnum::SECONE_REWARD_TYPE, 'before_balance' => $topInviter->balance, 'after_balance' => $topInviter->balance + Core::SECOND_DISTRIBUTOR_MONEY]);
        $topInviter->balanceDetails()->save($balanceDetail);
        $topInviter->balance += Core::SECOND_DISTRIBUTOR_MONEY;
        $topInviter->save();
    }

    //获取我的购买的下级
    /**
     * @param $underless
     * @return array
     */
    public function getBuyerUnder($underless)
    {
        $data = [];
        foreach ($underless as $underles){
            $order = Order::where('user_id',$underles->id)->where('status','>=',OrderEnum::PAYED)->first();
            if($order)
                $data[] = $underles->id;
        }
        return $data;
    }


    public function test()
    {
        $user = User::find(12);
        $this->distributor($user);
    }
}
