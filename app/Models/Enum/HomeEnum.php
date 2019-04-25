<?php
namespace App\Models\Enum;
/**
 * Created by PhpStorm.
 * User: yinchuanjiang
 * Date: 2019/4/25
 * Time: 下午7:26
 */
class HomeEnum{
    // 状态类别
    const INVALID = -1; //不启用
    const NORMAL = 0; //启用

    public static function getStatusName($status){
        switch ($status){
            case self::INVALID:
                return '不启用';
            case self::NORMAL:
                return '正常';
            default:
                return '正常';
        }
    }
}