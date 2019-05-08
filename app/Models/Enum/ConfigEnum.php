<?php
namespace App\Models\Enum;
use Illuminate\Support\Facades\DB;

/**
 * Created by PhpStorm.
 * User: yinchuanjiang
 * Date: 2019/4/25
 * Time: 下午7:31
 */
class ConfigEnum{
    //系统配置转意
    const APP_HOME = '首页';
    const COMPANY_TEL = '客服电话';
    const COMPANY_HELP = '客服文案';
    const COMPANY_ABOUT_US = '关于我们';
    const USER_AGREEMENT = '用户协议';
    const ANDROID_VERSION = '安卓最新版本号';
    const IOS_VERSION = 'IOS最新版本号';
    public static function get($key)
    {
        switch ($key){
            case 'APP_HOME':
                $value = '首页';
                break;
            case 'COMPANY_TEL':
                $value = '客服电话';
                break;
            case 'COMPANY_HELP':
                $value = '客服文案';
                break;
            case 'COMPANY_ABOUT_US':
                $value = '关于我们';
                break;
            case 'USER_AGREEMENT':
                $value = '用户协议';
                break;
            case 'ANDROID_VERSION':
                $value = '安卓最新版本号';
                break;
            case 'IOS_VERSION':
                $value = 'IOS最新版本号';
                break;
            default:
                $value = '客服电话';
        }
        return $value;
    }

    public static function getValue($name)
    {
        $config = DB::table('configs')->where('name',$name)->first();
        return $config->value;
    }
}