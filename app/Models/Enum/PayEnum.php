<?php
namespace App\Models\Enum;
/**
 * Created by PhpStorm.
 * User: yinchuanjiang
 * Date: 2019/4/25
 * Time: 下午7:31
 */
class PayEnum{
    // 支付类别
    const ALIAPY = 'alipay'; //阿里支付
    const WECHAT_APP_PAY = 'wechat-app-pay'; //微信支付

    public static function getStatusName($status){
        switch ($status){
            case self::ALIAPY:
                return '阿里支付';
            case self::WECHAT_APP_PAY:
                return '微信支付';
            default:
                return '阿里支付';
        }
    }
}