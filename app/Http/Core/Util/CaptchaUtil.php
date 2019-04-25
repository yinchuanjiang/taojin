<?php
/**
 * Created by PhpStorm.
 * User: yinchuanjiang
 * Date: 2018/10/16
 * Time: 下午3:05
 */
namespace App\Http\Core\Util;

use App\Http\Core\Core;
use App\Models\Captcha;
use App\Models\Enum\CaptchaEnum;
use App\Models\User;
use Carbon\Carbon;
use Mrgoon\AliSms\AliSms;

class CaptchaUtil
{
    /**
     * 发送验证码
     * @param string $mobile
     * @param string $type
     * @return bool|\SimpleXMLElement[]
     */
    public static function send($mobile,$type)
    {
        $message = '';
        switch ($type){
            case CaptchaEnum::REGISTER:
                $user = User::where('mobile',$mobile)->first();
                if($user)
                    $message =  '用户已存在！';
                break;
            case CaptchaEnum::BIND_WEICHAT:
                $user = User::where('mobile',$mobile)->first();
                if($user) {
                    if($user->wx_oauth)
                        $message = '该手机号已绑定其他微信！';
                }
                break;
            default:
                $message = '';
        }
        if($message)
            return $message;
        $code = 888888;
//        $code = rand(100000,999999);
//        $aliSms = new AliSms();
//        $response = $aliSms->sendSms($mobile, env('ALIYUN_SMS_TEMPLATE_DOCTOR_LOGIN'), ['code'=> $code]);
//        if($response->Message == 'OK'){
            Captcha::create(['value'=>$code,'mobile'=>$mobile,'type'=>$type]);
            return true;
//        }
//        return $response->Message;
    }
    /**
     * 检查验证码
     * @param string $code
     * @param string $mobile
     * @param string $type
     * @return bool
     */
    public static function check($code,$mobile,$type)
    {
        $captha = Captcha::where(['type'=>$type,'value'=>$code,'mobile'=>$mobile,'is_used'=>Core::CAPTCHA_USED_FALSE])->where('created_at','>=',Carbon::now()->subMinute(Core::CAPTCHA_EXPIRE_TIME)->toDateTimeString())->first();
        if($captha) {
            return $captha;
        }
        return false;
    }
}