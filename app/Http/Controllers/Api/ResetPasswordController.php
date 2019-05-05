<?php

namespace App\Http\Controllers\Api;

use App\Http\Core\Core;
use App\Http\Core\Util\CaptchaUtil;
use App\Http\Requests\Api\ResetPasswordRequest;
use App\Models\Enum\CaptchaEnum;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;

class ResetPasswordController extends Controller
{
    //重置密码
    /**
     * @api {POST} user/reset-password 重置密码
     * @apiSampleRequest user/reset-password
     * @apiParam {String} mobile      手机号(必填)
     * @apiParam {String} code        验证码(必填)
     * @apiParam {String} password    密码(必填)
     * @apiPermission 无
     * @apiName reset-password
     * @apiGroup U-User
     * @apiVersion 1.0.0
     * @apiDescription   api   重置密码
     * @apiSuccessExample Success-Response:
     *     HTTP/1.1 200 OK
     *     {
     *          "status":"200",
     *          "msg":"重置密码成功",
     *          "data": []
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
    public function resetPassword(ResetPasswordRequest $request)
    {
        $data = $request->all(['mobile','password','code']);
        if (!($captcha = CaptchaUtil::check($data['code'], $data['mobile'], CaptchaEnum::RESET_PASSWORD))) {
            return show(Core::HTTP_ERROR_CODE, '验证码错误或过期');
        }
        unset($data['code']);
        $user = $this->user;
        $user->password = Hash::make($data['password']);
        $captcha->is_used = CaptchaEnum::CAPTCHA_USED_TRUE;
        $user->save();
        $captcha->save();
        return show(Core::HTTP_SUCCESS_CODE, '密码设置成功');
    }
}
