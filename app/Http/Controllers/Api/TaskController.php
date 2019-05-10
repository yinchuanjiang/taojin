<?php

namespace App\Http\Controllers\Api;

use App\Models\Enum\OrderEnum;
use App\Models\Order;
use App\Http\Controllers\Controller;

class TaskController extends Controller
{
    //取消订单
    public function cancelOrder()
    {
        $orders = Order::where('status',OrderEnum::PAYING)->where('created_at','<=',now()->subSeconds(OrderEnum::AUTO_CANCEL_TIME))->get();
        if(!$orders)
            return;
        foreach ($orders as $order)
        {
            $order->status = OrderEnum::CANCEL;
            $order->save();
        }
        return;
    }
}
