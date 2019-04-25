<?php

namespace App\Http\Controllers\Api;

use App\Http\Core\Core;
use App\Http\Proxy\TokenProxy;
use App\Http\Requests\Api\LoginRequest;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{

    protected $proxy;

    /**
     * LoginController constructor.
     * @param TokenProxy $proxy
     */
    public function __construct(TokenProxy $proxy)
    {
        $this->proxy = $proxy;
    }

    /**
     * @api {POST} login 登录
     * @apiSampleRequest login
     * @apiParam {String} wx_oauth  微信登录唯一凭证(选填)
     * @apiParam {String} mobile    手机号(wx_oauth不存在时必填)
     * @apiParam {String} password  密码(wx_oauth不存在时必填)
     * @apiPermission 无
     * @apiName login
     * @apiGroup B-Login
     * @apiVersion 1.0.0
     * @apiDescription   api   登录接口
     * @apiSuccessExample Success-Response:
     *     HTTP/1.1 200 OK
     *     {
     *          "status":"200",
     *          "msg":"登录成功",
     *          "data":{
     *              "token":"token",
     *              "refresh_token":"refresh_token",
     *              "user":{
     *                  "id":"id",
     *                  "mobile":"手机号",
     *                  "avatar":"头像"
     *              },
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
    public function login(LoginRequest $request)
    {
        $data = $request->all();
        if ($data['wx_oauth']) {
            $user = User::where('wx_oauth', $data['wx_oauth'])->first();
            if (!$user)
                return show(Core::HTTP_REDIRECT_CODE, '需要去绑定手机号');
            $data['mobile'] = $user->mobile;
        } else {
            $user = User::where('mobile', $data['mobile'])->first();
            if (!Hash::check($data['password'], $user->password)) {
                return show(Core::HTTP_ERROR_CODE, '密码错误');
            }
        }
        $token = $this->proxy->login($data['mobile'], $data['mobile']);
        if (!$token) {
            return show(Core::HTTP_ERROR_CODE, '系统异常');
        }
        return show(
            Core::HTTP_SUCCESS_CODE,
            '登录成功',
            [
                'token' => $token['token'],
                'refresh_token' => $token['refresh_token'],
                //'expires_in' => $token['expires_in'],
                'user' => $user
            ]
        );
    }
}
