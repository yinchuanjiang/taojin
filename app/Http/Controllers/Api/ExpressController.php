<?php

namespace App\Http\Controllers\Api;

use App\Http\Core\Core;
use App\Models\Enum\OrderEnum;
use App\Models\Order;
use GuzzleHttp\Client;

class ExpressController extends ApiBaseController
{
    protected $http;

    /**
     * TokenProxy constructor.
     * @param Client $http
     */
    public function __construct(Client $http)
    {
        $this->http = $http;
    }
    //快递详情
    /**
     * @api {POST} order/express/:order_id 快递详情
     * @apiSampleRequest order/express/:order_id
     * @apiHeader {String} authorization Authorization value.
     * @apiPermission 无
     * @apiName express
     * @apiGroup J-Express
     * @apiVersion 1.0.0
     * @apiDescription   api   快递详情
     * @apiSuccessExample Success-Response:
     *     HTTP/1.1 200 OK
     *     {
     *          "status":"200",
     *          "msg":"获取成功",
     *          "data":[
     *              "express":[
     *                  {
     *                      "time":"时间",
     *                      "content":"内容"
     *                  }
     *              ],
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
    public function index(Order $order)
    {
        if($order->status < OrderEnum::POSTED)
            return show(Core::HTTP_ERROR_CODE,'暂未发货，不可查询');
        $url = 'http://www.kuaidi100.com/query?type=' . $order->express->code . '&postid=' . $order->express_code . '&id=1&valicode=&temp=' . rand(1000,9999) . '&sessionid=&tmp=' . rand(1000,9999);
        $response = $this->http->get($url);
        if($response->getStatusCode() != Core::HTTP_SUCCESS_CODE)
            return show(Core::HTTP_ERROR_CODE,'物流信息查询失败');
        $response = json_decode($response->getBody(), true);
        // $content['data'] = array_reverse($content['data']);
        $express = array();
        if (is_array($response['data'])) {
            foreach ($response['data'] as $k => $v) {
                if ($v['time'] == '')
                    continue;
                $express[$k]['time']    = $v['time'];
                $express[$k]['context'] = $v['context'];
            }
        }
        return show(Core::HTTP_SUCCESS_CODE,'查询成功',compact('express'));
    }
}
