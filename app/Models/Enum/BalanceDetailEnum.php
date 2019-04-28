<?php
namespace App\Models\Enum;
/**
 * Created by PhpStorm.
 * User: yinchuanjiang
 * Date: 2019/4/25
 * Time: 下午7:31
 */
class BalanceDetailEnum{
    // 类型
    const FIRST_REWARD_TYPE = 10000;//一级推广奖励
    const SECONE_REWARD_TYPE = 10001; //二级推广奖励
    const WITHDRAW_CASH = 10003;//提现

    public static function getStatusName($status){
        switch ($status){
            case self::FIRST_REWARD_TYPE:
                return '一级推广奖励';
            case self::SECONE_REWARD_TYPE:
                return '二级推广奖励';
            case self::WITHDRAW_CASH:
                return '提现';
            default:
                return '提现';
        }
    }
}