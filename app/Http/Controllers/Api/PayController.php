<?php

namespace App\Http\Controllers\Api;

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
     * @apiParam {String} type  支付方式(必填【'alipay','wechat-app-pay'】)
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
    public function pay(PayRequest $request,Order $order)
    {
        $data = $request->all();
        switch ($data['type']){
            case PayEnum::ALIAPY:
                return $this->alipay($order);
                break;
        }
    }
    //alipay
    public function alipay($order)
    {
        $payData = [
            'body'            => '淘金-订单支付',
            'subject'         => '淘金',
            'out_trade_no'    => $order['sn'],
            //'total_amount'    => $order['total'],
            'total_amount'    => '0.01',
            'product_code'    => 'QUICK_MSECURITY_PAY'
        ];
        return Pay::alipay()->app($payData);
    }
}
