<?php

namespace App\Http\Controllers\Api;

use App\Http\Core\Core;
use App\Http\Core\Util\CaptchaUtil;
use App\Http\Requests\Api\RegisterRequest;
use App\Models\Enum\CaptchaEnum;
use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    /**
     * @api {POST} register 注册
     * @apiSampleRequest register
     * @apiParam {String} mobile    手机号(必填)
     * @apiParam {String} code      验证码(必填)
     * @apiParam {String} wx_oauth  微信登录唯一凭证(选填)
     * @apiParam {String} password  密码(必填)
     * @apiParam {String} avatar    用户头像(wx_oauth存在时必填)
     * @apiPermission 无
     * @apiName register
     * @apiGroup A-Register
     * @apiVersion 1.0.0
     * @apiDescription   api   注册接口
     * @apiSuccessExample Success-Response:
     *     HTTP/1.1 200 OK
     *     {
     *          "status":"200",
     *          "msg":"注册成功",
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
    public function register(RegisterRequest $request)
    {
        $data = $request->all();
        if (!$captcha = CaptchaUtil::check($data['code'], $data['mobile'], CaptchaEnum::REGISTER)) {
            return show(Core::HTTP_ERROR_CODE, '验证码错误或过期');
        }
        unset($data['code']);
        $data['password'] = Hash::make($data['password']);
        User::create($data);
        return show(Core::HTTP_SUCCESS_CODE, '用户注册成功');
    }
}
