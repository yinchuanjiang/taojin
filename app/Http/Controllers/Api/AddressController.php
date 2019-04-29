<?php

namespace App\Http\Controllers\Api;

use App\Http\Core\Core;
use App\Http\Requests\Api\AddressRequest;
use App\Http\Resources\Api\AddressResource;
use App\Models\Address;

class AddressController extends ApiBaseController
{
    /**
     * @api {POST} address 地址列表
     * @apiSampleRequest address
     * @apiHeader {String} authorization Authorization value.
     * @apiPermission 无
     * @apiName address
     * @apiGroup F-Address
     * @apiVersion 1.0.0
     * @apiDescription   api   地址接口
     * @apiSuccessExample Success-Response:
     *     HTTP/1.1 200 OK
     *     {
     *          "status":"200",
     *          "msg":"获取成功",
     *          "data":[
     *              "address":[
     *                  {
     *                      "id":"id",
     *                      "to_name":"收件人",
     *                      "mobile":"手机号",
     *                      "province":"省",
     *                      "city":"市",
     *                      "area":"区",
     *                      "detail":"详细地址",
     *                      "postcode":"邮政编码"
     *                  }
     *              ],
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
    public function index()
    {
        $address = AddressResource::collection($this->user->address);
        return show(Core::HTTP_SUCCESS_CODE,'获取成功',compact('address'));
    }
    
    //新增加地址
    /**
     * @api {POST} address/store 增加地址
     * @apiSampleRequest address/store
     * @apiParam {String} to_name     收件人(必填)
     * @apiParam {String} mobile      收件人手机号(必填)
     * @apiParam {String} address     省+市+区(必填)
     * @apiParam {String} detail      详细地址(选填)
     * @apiParam {String} postcode    邮政编码(选填)
     * @apiHeader {String} authorization Authorization value.
     * @apiPermission 无
     * @apiName address/store
     * @apiGroup F-Address
     * @apiVersion 1.0.0
     * @apiDescription   api   增加地址接口
     * @apiSuccessExample Success-Response:
     *     HTTP/1.1 200 OK
     *     {
     *          "status":"200",
     *          "msg":"添加成功",
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
    public function store(AddressRequest $request)
    {
        $data = $request->all(['to_name','mobile','address','detail','postcode']);
        if($this->user->address->count())
            return show(Core::HTTP_ERROR_CODE,'已存在地址');
        $address = new Address($data);
        $this->user->address()->save($address);
        return show(Core::HTTP_SUCCESS_CODE,'添加成功');
    }

    //修改地址
    /**
     * @api {POST} address/update/:id 修改地址
     * @apiSampleRequest address/update/:id
     * @apiParam {String} to_name     收件人(必填)
     * @apiParam {String} mobile      收件人手机号(必填)
     * @apiParam {String} address     省+市+区(必填)
     * @apiParam {String} detail      详细地址(选填)
     * @apiParam {String} postcode    邮政编码(选填)
     * @apiHeader {String} Authorization Authorization value.
     * @apiPermission 无
     * @apiName address/update
     * @apiGroup F-Address
     * @apiVersion 1.0.0
     * @apiDescription   api   修改地址接口
     * @apiSuccessExample Success-Response:
     *     HTTP/1.1 200 OK
     *     {
     *          "status":"200",
     *          "msg":"修改成功",
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
    public function update(AddressRequest $request,Address $address)
    {
        $data = $request->all(['to_name','mobile','address','detail','postcode']);
        if($this->user->id !== $address->user_id)
            return show(Core::HTTP_ERROR_CODE,'非法操作');
        $address->update($data);
        return show(Core::HTTP_SUCCESS_CODE,'修改成功');
    }
}
