<?php

namespace App\Http\Controllers\Api;

use App\Http\Core\Core;
use App\Http\Core\Util\CaptchaUtil;
use App\Http\Requests\Api\BindRequest;
use App\Models\Enum\CaptchaEnum;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class BindController extends Controller
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
     * @api {POST} bind 绑定手机号
     * @apiSampleRequest bind
     * @apiParam {String} wx_oauth  微信登录唯一凭证(必填)
     * @apiParam {String} mobile    手机号(必填)
     * @apiParam {String} code      密码(必填)
     * @apiPermission 无
     * @apiName bind
     * @apiGroup B-bind
     * @apiVersion 1.0.0
     * @apiDescription   api   绑定手机号
     * @apiSuccessExample Success-Response:
     *     HTTP/1.1 200 OK
     *     {
     *          "status":"200",
     *          "msg":"绑定成功",
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
     *          "msg":"绑定成功",
     *          "data":[]
     *      }
     */
    public function bind(BindRequest $request)
    {
        $data = $request->all();
        if (!$captcha = CaptchaUtil::check($data['code'], $data['mobile'], CaptchaEnum::BIND_WEICHAT)) {
            return show(Core::HTTP_ERROR_CODE, '验证码错误或过期');
        }
        $user = User::where('mobile',$data['mobile'])->first();
        if($user){
            $user->wx_oauth = $data['wx_oauth'];
            $user->avatar = $data['avatar'];
            $user->save();
        }else{
            unset($data['code']);
            $user = User::create($data);
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
