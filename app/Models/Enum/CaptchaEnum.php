<?php
/**
 * Created by PhpStorm.
 * User: yinchuanjiang
 * Date: 2019/4/24
 * Time: 下午7:49
 */
namespace App\Models\Enum;
class CaptchaEnum
{
    // 状态类别
    const REGISTER = '10000'; //注册
    const RESET_PASSWORD = '10001'; //修改密码
    const BIND_WEICHAT = '10002'; // 绑定微信

    const CAPTCHA_USED_FALSE = -1;//验证码未使用
    const CAPTCHA_EXPIRE_TIME = 5;//验证码过期时间 分钟
    const CAPTCHA_USED_TRUE = 1; //验证码使用

    public static function getTypeName($type){
        switch ($type){
            case self::REGISTER:
                return '注册';
            case self::RESET_PASSWORD:
                return '修改密码';
            case self::BIND_WEICHAT:
                return '绑定微信';
            default:
                return '注册';
        }
    }
}