<?php

namespace App\Http\Controllers\Api;

use App\Http\Core\Core;
use App\Http\Core\Util\CaptchaUtil;
use App\Http\Requests\Api\CaptchaRequest;
use App\Http\Controllers\Controller;
use App\Models\Enum\CaptchaEnum;
use App\Models\User;

class CaptchaController extends Controller
{
    //发送验证码
    /**
     * @api {POST} captcha/send 发送验证码
     * @apiSampleRequest captcha/send
     * @apiParam {String} mobile    手机号(必填)
     * @apiParam {String} type      密码(类型【注册:'10000'】 【修改密码:'10001'】 【绑定微信:'10002'】 )
     * @apiPermission 无
     * @apiName captcha/send
     * @apiGroup C-Captcha
     * @apiVersion 1.0.0
     * @apiDescription   api   发送验证码接口
     * @apiSuccessExample Success-Response:
     *     HTTP/1.1 200 OK
     *     {
     *          "status":"200",
     *          "msg":"发送成功",
     *          "data":{
     *              "set_password":"bool"
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
    public function send(CaptchaRequest $request)
    {
        $data = $request->all(['mobile','type']);
        if(($message = CaptchaUtil::send($data['mobile'],$data['type'])) !== true){
            return show(Core::HTTP_ERROR_CODE, $message);
        }
        $set_password = false;
        if($data['type'] == CaptchaEnum::BIND_WEICHAT) {
            $user = User::where('mobile', $data['mobile'])->first();
            if(!$user || ($user && !$user->password))
                $set_password = true;
        }
        return show(Core::HTTP_SUCCESS_CODE, '发送成功',compact('set_password'));
    }
}
