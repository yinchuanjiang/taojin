<?php

namespace App\Http\Controllers\Api;

use App\Http\Core\Core;
use App\Http\Requests\Api\OrderRequest;
use App\Http\Resources\Api\AddressResource;
use App\Http\Resources\Api\OrderResource;
use App\Models\Address;
use App\Models\Enum\OrderEnum;
use App\Models\Good;
use App\Models\Order;

class OrderController extends ApiBaseController
{
    //订单列表
    /**
     * @api {POST} order 订单列表
     * @apiSampleRequest order
     * @apiParam {String} status    订单状态(-1取消 0待付款 1待发货 2待收货 3已完成)
     * @apiParam {Number} page      分页(选填 默认1)
     * @apiParam {Number} limit     每页条数(选填 默认15)
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
     *          "data":{
     *              "orders":[
     *                  {
     *                      "id":"ID",
     *                      "sn":"订单号",
     *                      "quantity":"购买数量",
     *                      "total":"总金额",
     *                      "status":"订单状态",
     *                  }
     *              ]
     *          }
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
        $data = Order::where('user_id',$this->user->id)->search()->paginate($this->limit)->pluck('id')->toArray();
        $orders = OrderResource::collection(Order::whereIn('id',$data)->orderBy('id','desc')->get());
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
     *          "data":{
     *              "order_id:":"订单id"
     *          }
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
        $data['total'] = $good->price * $data['quantity'];
        $data['user_id'] = $this->user->id;
        $data['good_id'] = $good->id;
        $data['sn'] = makeSn();
        $data['address'] = json_encode(new AddressResource($address));
        $order = Order::create($data);
        //$good->decrement('stock');
        $good->increment('sales_volume');
        $good->save();
        return show(Core::HTTP_SUCCESS_CODE,'下单成功',['order_id' => $order->id]);
    }

    //订单详情
    /**
     * @api {POST} order/show/:id 订单详情
     * @apiSampleRequest order/show/:id
     * @apiHeader {String} authorization Authorization value.
     * @apiPermission 无
     * @apiName show
     * @apiGroup F-Order
     * @apiVersion 1.0.0
     * @apiDescription   api   订单详情
     * @apiSuccessExample Success-Response:
     *     HTTP/1.1 200 OK
     *     {
     *          "status":"200",
     *          "msg":"获取成功",
     *          "data":{
     *              "orderd":
     *                  {
     *                      "id":"ID",
     *                      "sn":"订单号",
     *                      "quantity":"购买数量",
     *                      "total":"总金额",
     *                      "status":"订单状态",
     *                      "address":{
     *                          "id":"ID",
     *                          "to_name":"收件人",
     *                          "mobile":"手机号",
     *                          "address":"地址",
     *                          "detail":"详细地址",
     *                          "postcode":"邮政编码"
     *                      }
     *                      "good":[
     *                          "id":"商品id",
     *                          "title":"商品标题",
     *                          "price":"商品价格",
     *                          "sales_volume":"销量",
     *                          "describe":"描述",
     *                          "stock":"库存",
     *                          "good_imgs":[
     *                           {
     *                               "id":"商品图片id",
     *                               "img_url":"图片链接",
     *                            }
     *                          ],
     *                      ]
     *                  }
     *          }
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
    public function show(Order $order)
    {
        if($order->user_id != $this->user->id)
            return show(Core::HTTP_ERROR_CODE,'非法操作');
        $order = new OrderResource($order);
        return show(Core::HTTP_SUCCESS_CODE,'获取成功',compact('order'));
    }
    //确认收货
    /**
     * @api {POST} order/confirm/:id 确认收货
     * @apiSampleRequest order/confirm/:id
     * @apiHeader {String} authorization Authorization value.
     * @apiPermission 无
     * @apiName confirm
     * @apiGroup F-Order
     * @apiVersion 1.0.0
     * @apiDescription   api   确认收货
     * @apiSuccessExample Success-Response:
     *     HTTP/1.1 200 OK
     *     {
     *          "status":"200",
     *          "msg":"收货成功",
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
    public function confirm(Order $order)
    {
        if($order->user_id != $this->user->id)
            return show(Core::HTTP_ERROR_CODE,'非法操作');
        if($order->status != OrderEnum::POSTED)
            return show(Core::HTTP_ERROR_CODE,'非发货不能收货');
        $order->status = OrderEnum::FINISH;
        $order->save();
        return show(Core::HTTP_SUCCESS_CODE,'收货成功');
    }

    //取消订单
    /**
     * @api {POST} order/cancel/:id 取消订单
     * @apiSampleRequest order/cancel/:id
     * @apiHeader {String} authorization Authorization value.
     * @apiPermission 无
     * @apiName cancel
     * @apiGroup F-Order
     * @apiVersion 1.0.0
     * @apiDescription   api   取消订单
     * @apiSuccessExample Success-Response:
     *     HTTP/1.1 200 OK
     *     {
     *          "status":"200",
     *          "msg":"取消成功",
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
    public function cancel(Order $order)
    {
        if($order->user_id != $this->user->id)
            return show(Core::HTTP_ERROR_CODE,'非法操作');
        if($order->status >= OrderEnum::PAYED)
            return show(Core::HTTP_ERROR_CODE,'非法操作,改状态下订单不能取消');
        $order->status = OrderEnum::CANCEL;
        $order->save();
        return show(Core::HTTP_SUCCESS_CODE,'取消成功');
    }
}
