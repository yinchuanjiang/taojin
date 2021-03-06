<?php

namespace App\Http\Controllers\Api;

use App\Http\Core\Core;
use App\Http\Resources\Api\AddressResource;
use App\Http\Resources\Api\GoodResource;
use App\Models\Address;
use App\Models\Enum\GoodEnum;
use App\Models\Good;
use App\Http\Controllers\Controller;

class GoodController extends Controller
{
    /**
     * @api {POST} good 商品
     * @apiSampleRequest good
     * @apiHeader {String} authorization Authorization value.
     * @apiPermission 无
     * @apiName home
     * @apiGroup E-Good
     * @apiVersion 1.0.0
     * @apiDescription   api   商品接口
     * @apiSuccessExample Success-Response:
     *     HTTP/1.1 200 OK
     *     {
     *          "status":"200",
     *          "msg":"获取成功",
     *          "data":[
     *              "good":{
     *                  "id":"id",
     *                  "title":"商品标题",
     *                  "price":"商品价格",
     *                  "sales_volume":"销量",
     *                  "describe":"描述",
     *                  "stock":"库存",
     *                  "good_imgs":[
     *                      {
     *                          "id":"商品图片id",
     *                          "img_url":"图片链接",
     *                      }
     *                  ],
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
    public function index()
    {
        $good = new GoodResource(Good::where('status',GoodEnum::NORMAL)->first());
        if(!$good)
            return show(Core::HTTP_ERROR_CODE,'数据异常');
        $address = [];
        $user = request()->user('api');
        if($user && $user->address->count())
            $address = new AddressResource(Address::where('user_id',$user->id)->first());
        return show(Core::HTTP_SUCCESS_CODE,'获取成功',compact('good','address'));
    }
}
