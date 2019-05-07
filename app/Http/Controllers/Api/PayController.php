<?php

namespace App\Http\Controllers\Api;

use App\Http\Core\Core;
use App\Http\Requests\Api\PayRequest;
use App\Models\BalanceDetail;
use App\Models\Enum\BalanceDetailEnum;
use App\Models\Enum\OrderEnum;
use App\Models\Enum\PayEnum;
use App\Models\Order;
use App\Models\User;
use Illuminate\Support\Facades\Log;
use Yansongda\LaravelPay\Facades\Pay;

class PayController extends ApiBaseController
{
    //支付
    /**
     * @api {POST} pay/:order_id 支付
     * @apiSampleRequest pay/:order_id
     * @apiParam {String} type  支付方式(必填【'alipay','wxpay'】)
     * @apiHeader {String} authorization Authorization value.
     * @apiPermission 无
     * @apiName pay
     * @apiGroup G-Pay
     * @apiVersion 1.0.0
     * @apiDescription   api   支付
     * @apiSuccessExample Success-Response:
     *     HTTP/1.1 200 OK
     *     {
     *          "status":"200",
     *          "msg":"支付链接创建成功",
     *          "data":[
     *              "pay_url":"支付链接"
     *          ]
     *     }
     *
     *
     * @apiErrorExample Error-Response:
     *     HTTP/1.1 422 Not Found  422错误提示,请使用ajax异常扑获取
     *      {
     *          "message": "The given data was invalid.",
     *              "errors": {
     *                   "type": [
     *                       "type 不能为空。"
     *                   ]
     *               }
     *            }
     * @apiErrorExample Error-Response:
     *      {
     *          "status":"400",
     *          "msg":"错误提示",
     *          "data":[]
     *      }
     */
    public function pay(PayRequest $request, Order $order)
    {
        $data = $request->all();
        if ($order->user->id !== $this->user->id)
            return show(Core::HTTP_SUCCESS_CODE, '非法操作');
        switch ($data['type']) {
            case PayEnum::ALIAPY:
                return $this->alipay($order);
                break;
            case PayEnum::WECHAT_APP_PAY:
                return $this->wxpay($order);
                break;
        }
    }

    //wxpay

    public function alipay($order)
    {
        $payData = [
            'body' => '淘金-订单支付',
            'subject' => '淘金',
            'out_trade_no' => $order['sn'],
            'notify_url' => route('pay.notify'),
            //'return_url' => 'http://yansongda.cn/return.php',
            'total_amount' => '0.01',
            'product_code' => 'QUICK_MSECURITY_PAY'
        ];
        $pay_url = Pay::alipay()->app($payData)->getContent();
        return show(Core::HTTP_SUCCESS_CODE, '生成支付链接成功', compact('pay_url'));
    }

    //alipay

    public function wxpay($order)
    {
        $payData = [
            'attach' => '淘金',
            'body' => '淘金-订单支付',
            'nonce_str' => md5(rand(1, 100000000)),
            'notify_url' => route('pay.wx-notify'),
            'out_trade_no' => $order['sn'],
            'spbill_create_ip' => $_SERVER['REMOTE_ADDR'],
            //'total_fee'        => intval($order['total'] * 100), //实际金额
            'total_fee' => 1, //测试
            'trade_type' => 'APP',
        ];
        $pay_url = \GuzzleHttp\json_decode(Pay::wechat()->app($payData)->getContent(),true);
        return show(Core::HTTP_SUCCESS_CODE, '生成支付链接成功', compact('pay_url'));
    }

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
                if ($data->total_amount != $order->total)
                    die;
                $order->status = OrderEnum::PAYED;
                $this->distributor($order->user);
                $order->save();
            }
            // 3、校验通知中的seller_id（或者seller_email) 是否为out_trade_no这笔单据的对应的操作方（有的时候，一个商户可能有多个seller_id/seller_email）；
            // 4、验证app_id是否为该商户本身。
            // 5、其它业务逻辑情况

            Log::debug('Alipay notify', $data->all());
        } catch (\Exception $e) {
            Log::debug('Alipay notify error', $e->getMessage());
        }

        return $alipay->success();// laravel 框架中请直接 `return $alipay->success()`
    }

    /**
     * 微信异步通知
     * @return mixed
     */
    public function wxNotify()
    {
        $pay = Pay::wechat($this->config);

        try{
            $data = $pay->verify(); // 是的，验签就这么简单！

            Log::debug('Wechat notify', $data->all());
        } catch (\Exception $e) {
            // $e->getMessage();
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
        $orders = $buyer->orders()->where('status', OrderEnum::PAYED)->get();
        if (count($orders) > 1)
            return;
        if (!$buyer->invite_id)
            return;
        /** @var User $inviter */
        $inviter = $buyer->inviter;
        $underless = $inviter->underless()->count();
        //一级分销 推荐2人推荐人加 500
        if ($underless % Core::FIRST_DISTRIBUTOR_PEOPLE == 0) {
            $balanceDetail = new BalanceDetail(['cash' => Core::FIRST_DISTRIBUTOR_MONEY, 'type' => BalanceDetailEnum::FIRST_REWARD_TYPE, 'before_balance' => $inviter->balance, 'after_balance' => $inviter->balance + Core::FIRST_DISTRIBUTOR_MONEY]);
            $inviter->balanceDetails()->save($balanceDetail);
        }
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
            /** @var User $allUnderles */
            $underTeam[] = $allUnderles->underless()->count() % 2 == 0 ? 'ok' : 'no';
        }
        $result = array_count_values($underTeam);
        if (!isset($result['ok']))
            return;
        if ($result['ok'] % Core::SECOND_DISTRIBUTOR_PEOPLE != 0)
            return;
        $balanceDetail = new BalanceDetail(['cash' => Core::SECOND_DISTRIBUTOR_MONEY, 'type' => BalanceDetailEnum::SECONE_REWARD_TYPE, 'before_balance' => $topInviter->balance, 'after_balance' => $topInviter->balance + Core::SECOND_DISTRIBUTOR_MONEY]);
        $inviter->balanceDetails()->save($balanceDetail);
    }
}
