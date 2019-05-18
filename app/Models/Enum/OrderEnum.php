<?php
namespace App\Models\Enum;
/**
 * Created by PhpStorm.
 * User: yinchuanjiang
 * Date: 2019/4/25
 * Time: 下午7:31
 */
class OrderEnum{
    // 状态类别
    const CANCEL = -1; //已取消
    const PAYING = 0; //待付款
    const PAYED = 1;//待发货
    const POSTED = 2;//待收货
    const FINISH = 3;//已完成
    const AUTO_CANCEL_TIME = 30;//订单字段取消时间/分钟

    const ALIYPAY = '1000';
    const WEICHAT_PAY = '10001';

    public static function getStatusName($status){
        switch ($status){
            case self::CANCEL:
                return '已取消';
            case self::PAYING:
                return '待付款';
            case self::PAYED:
                return '待发货';
            case self::POSTED:
                return '已发货';
            case self::FINISH:
                return '已完成';
            case self::ALIYPAY:
                return '支付宝';
            case self::WEICHAT_PAY:
                return '微信支付';
            default:
                return '已完成';
        }
    }
}