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
    /** 用户满意 */
    const AGREE_TRUE = 1;
    /** 用户不满意 */
    const AGREE_FALSE = -1;
    /** 已绑定 */
    const BIND_TRUE = 1;
    /** 已解除绑定 */
    const BIND_FALSE = -1;
    /** 题库已回答 */
    const ANSWERED_TRUE = 1;
    /** 题库未回答 */
    const ANSWERED_FALSE = -1;
    /** 用户角色 患者 */
    const ROLE_SLEEP = 1;
    /** 用户角色 医生 */
    const ROLE_DOCTOR = 2;
    /** 用户角色 */
    const ROLE_ADMIN = 3;
    /** 后台分页 每页数据 */
    const ADMIN_PAGE_LIMIT = 15;
    /** 题库题数最大数 */
    const EXAM_BANK_QUETION_MAX = 10;
    /** banner 图 患者端 */
    const BANNER_IMAGE_PATIENT = 1;
    /** banner 图 医生端 */
    const BANNER_IMAGE_DOCTOR = 2;
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
    /** 我的回答的题目回收 否 */
    const TRASHED_FALSE = -1;
    /** 我的回答的题目回收  是*/
    const TRASHED_TRUE = 1;
    /** 推送 否 */
    const PUSHED_FALSE = -1;
    /** 推送 是 */
    const PUSHED_TRUE = 1;
    /** 验证码类型 医生登录 */
    const DOCTOR_LOGIN_CAPTCHA = 10000;
    /** 验证码是否使用 未使用 */
    const CAPTCHA_USED_FALSE = -1;
    /** 验证码是否使用 使用 */
    const CAPTCHA_USED_TRUE = 1;
    /** 验证码失效时间 */
    const CAPTCHA_EXPIRE_TIME = 5;
    /** 验证码每日最大限制 */
    const CAPTCHA_MAX_COUNT = 5;
    /** 重置密码 默认值 */
    const ADMIN_DEFAULT_PASSWORD = 888888;

    /** formId是否使用 未使用 */
    const FORMID_USED_FALSE = -1;
    /** formId是否使用 使用 */
    const FORMID_USED_TRUE = 1;
    /** formid 过期时间 */
    const FORMID_EXPIRED_TIME = 6;

    /** formid 收集最大数 */
    const FORMID_MAX_COUNT = 100;

    /** 用户是否激活 */
    const ACTIVE_FALSE = -1;
    const ACTIVE_TRUE = 1;

    /** 题库类型 医生和推送 */
    const EXAM_BANK_TYPE_DOCTOR = 1;//数据库默认值
    const EXAM_BANK_TYPE_SYSTEM = 2;

    /** 用户不停切换歌曲判断系数  切换歌曲数  切换时间纬度  CUT_MUSIC_NUM 首歌曲切换 平均时间是小于等于 CUT_EACH_MUSIC_SECOND的需要回答音乐喜好问卷 回答过的不用回答 */
    const CUT_MUSIC_NUM = 5;//5首歌曲
    const CUT_EACH_MUSIC_SECOND = 10;//10秒
}