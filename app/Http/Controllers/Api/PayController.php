<?php

namespace App\Http\Controllers\Api;

use App\Http\Core\Core;
use App\Http\Requests\Api\PayRequest;
use App\Models\Enum\PayEnum;
use App\Models\Order;
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
            'out_trade_no' => $order->sn,
            'notify_url' => route('verify.notify'),
            'total_amount' => $order->total,
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
            'notify_url' => route('verify.wx-notify'),
            'out_trade_no' => $order->sn,
            'spbill_create_ip' => $_SERVER['REMOTE_ADDR'],
            //'total_fee'        => intval($order['total'] * 100), //实际金额
            'total_fee' => intval($order->total * 100), //测试
            'trade_type' => 'APP',
        ];
        $pay_url = \GuzzleHttp\json_decode(Pay::wechat()->app($payData)->getContent(),true);
        return show(Core::HTTP_SUCCESS_CODE, '生成支付链接成功', compact('pay_url'));
    }
}
