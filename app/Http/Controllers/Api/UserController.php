<?php

namespace App\Http\Controllers\Api;


use App\Http\Core\Core;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class UserController extends ApiBaseController
{
    //我的团队
    /**
     * @api {POST} user/invites 我的团队
     * @apiSampleRequest user/invites
     * @apiHeader {String} authorization Authorization value.
     * @apiPermission 无
     * @apiName invites
     * @apiGroup U-User
     * @apiVersion 1.0.0
     * @apiDescription   api   我的团队
     * @apiSuccessExample Success-Response:
     *     HTTP/1.1 200 OK
     *     {
     *          "status":"200",
     *          "msg":"获取成功",
     *          "data":{
     *              "total":"团队人数",
     *              "img":"推广二维码"
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
    public function invites()
    {
        $invites = $this->user->ivites;
        $total = 0;
        if($invites) {
            foreach ($invites as $invite){
                if($invite->$invites)
                    $total += count($invite->$invites);
            }
        }
        QrCode::format('png')->size(250)->generate(route('web.register',['invite_id' => $this->user->id]),'./qrcode/'.$this->user->id.'.png');
        $img = config('app.url').'qrcode/'.$this->user->id.'.png';
        return show(Core::HTTP_SUCCESS_CODE,'获取成功',compact('total','img'));
    }
}
