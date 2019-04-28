<?php

namespace App\Http\Controllers\Api;


use App\Http\Core\Core;
use App\Http\Resources\Api\BalanceDetailResource;
use App\Models\BalanceDetail;

class BalanceDetailController extends ApiBaseController
{
    //资金记录
    /**
     * @api {POST} balance/detail 资金记录
     * @apiSampleRequest balance/detail
     * @apiHeader {String} authorization Authorization value.
     * @apiPermission 无
     * @apiName balance
     * @apiGroup H-Balance
     * @apiVersion 1.0.0
     * @apiDescription   api   资金记录
     * @apiSuccessExample Success-Response:
     *     HTTP/1.1 200 OK
     *     {
     *          "status":"200",
     *          "msg":"获取成功",
     *          "data":{
     *              "details":[
     *                  {
     *                      "id":"ID",
     *                      "type":"类型",
     *                      "cash":"金额",
     *                      "created_at":"发生时间",
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
        $details = BalanceDetailResource::collection(BalanceDetail::where('user_id',$this->user->id)->order('id','desc')->get());
        return show(Core::HTTP_SUCCESS_CODE,'获取成功',compact('details'));
    }
}
