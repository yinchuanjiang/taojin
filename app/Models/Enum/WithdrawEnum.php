<?php
namespace App\Models\Enum;
/**
 * Created by PhpStorm.
 * User: yinchuanjiang
 * Date: 2019/4/25
 * Time: 下午7:31
 */
class WithdrawEnum{
    const INVALID = -1;//一级推广奖励
    const SUCCESS = 1; //二级推广奖励
    const APPLY = 0;//提现

    public static function getStatusName($status){
        switch ($status){
            case self::INVALID:
                return '处理失败';
            case self::SUCCESS:
                return '处理成功';
            case self::APPLY:
                return '申请提现';
            default:
                return '申请提现';
        }
    }
}