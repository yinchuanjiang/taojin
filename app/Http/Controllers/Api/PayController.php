<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\Api\PayRequest;
use App\Models\Enum\PayEnum;
use App\Models\Order;
use Yansongda\LaravelPay\Facades\Pay;

class PayController extends ApiBaseController
{
    //支付
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
        return Pay::alipay()->web($payData);
    }
}
