<?php

namespace App\Http\Core;
/**
 * 系统常量定义
 * Created by PhpStorm.
 * User: yinchuanjiang
 * Date: 2018/9/29
 * Time: 下午4:36
 */
class Core
{
    /** 用户性别 男 */
    const USER_GENDER_MALE = 1;
    /** 用户性别 女 */
    const USER_GENDER_FEMALE = 2;
    /** 后台分页 每页数据 */
    const ADMIN_PAGE_LIMIT = 15;
    /** 接口错误状态码 */
    const HTTP_ERROR_CODE = 400;
    /** 接口错误状态码 */
    const HTTP_REDIRECT_CODE = 302;
    /** 接口成功状态码 */
    const HTTP_SUCCESS_CODE = 200;
    /** 微信第三方接口成功 */
    const HTTP_WX_SUCCESS = 0;
    /** 接口返回数据条数 */
    const API_LIMIT = 15;
    /** 重置密码 默认值 */
    const ADMIN_DEFAULT_PASSWORD = 888888;

    const FIRST_DISTRIBUTOR_PEOPLE = 2;//一级分销分成人数单位

    const FIRST_DISTRIBUTOR_MONEY = 500.00;//一级分销分成金额

    const SECOND_DISTRIBUTOR_PEOPLE = 2;//二级分销分成人数单位

    const SECOND_DISTRIBUTOR_MONEY = 2500.00;//二级分销分成金额

    const DISTRIBUTOR_STATUS = true;//分销开关

}