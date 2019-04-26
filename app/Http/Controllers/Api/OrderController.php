<?php

namespace App\Http\Controllers\Api;

use App\Http\Core\Core;
use App\Http\Requests\Api\OrderRequest;
use App\Http\Resources\Api\OrderResource;
use App\Models\Address;
use App\Models\Good;
use App\Models\Order;

class OrderController extends ApiBaseController
{
    //订单列表
    /**
     * @api {POST} order 订单列表
     * @apiSampleRequest order
     * @apiParam {String} status    订单状态(-1取消 0待付款 1待发货 2待收货 3已完成)
     * @apiHeader {String} authorization Authorization value.
     * @apiPermission 无
     * @apiName order
     * @apiGroup F-Order
     * @apiVersion 1.0.0
     * @apiDescription   api   订单列表
     * @apiSuccessExample Success-Response:
     *     HTTP/1.1 200 OK
     *     {
     *          "status":"200",
     *          "msg":"获取成功",
     *          "data":[]
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
    public function index()
    {
        $orders = OrderResource::collection(Order::where('user_id',$this->user->id)->search()->get());
        return show(Core::HTTP_SUCCESS_CODE,'获取成功',compact('orders'));
    }
    //下单
    /**
     * @api {POST} order/store/:good_id/:address_id 下单
     * @apiSampleRequest order/store/:good_id/:address_id
     * @apiParam {Number} quantity  购买数量(必填)
     * @apiHeader {String} authorization Authorization value.
     * @apiPermission 无
     * @apiName order/store
     * @apiGroup F-Order
     * @apiVersion 1.0.0
     * @apiDescription   api   下单
     * @apiSuccessExample Success-Response:
     *     HTTP/1.1 200 OK
     *     {
     *          "status":"200",
     *          "msg":"下单成功",
     *          "data":[]
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
    public function store(OrderRequest $request,Good $good,Address $address)
    {
        $data = $request->all();
        dd($good);
    }
}
