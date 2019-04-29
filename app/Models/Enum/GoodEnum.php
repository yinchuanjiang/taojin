<?php
namespace App\Models\Enum;
/**
 * Created by PhpStorm.
 * User: yinchuanjiang
 * Date: 2019/4/25
 * Time: 下午7:31
 */
class GoodEnum{
    const GOOD_STATUS_TRUE = true;
    const GOOD_STATUS_FALSE = false;
    // 状态类别
    const INVALID = -1; //禁用
    const NORMAL = 0; //启用

    public static function getStatusName($status){
        switch ($status){
            case self::INVALID:
                return '禁用';
            case self::NORMAL:
                return '启用';
            default:
                return '启用';
        }
    }
}