<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::namespace('Api')->prefix('v1')->middleware('cors')->group(function () {
    Route::get('/oauth/redirect/{driver}','OAuthAuthorizationController@redirectToProvider');
    Route::get('oauth/callback/{driver}', 'OAuthAuthorizationController@handleProviderCallback');
    Route::get('/home','HomeController@index')->name('home.index');
    //发送验证码
    Route::post('/captcha/send','CaptchaController@send')->name('captcha.send');
    //注册
    Route::post('/register','RegisterController@register')->name('register.register');
    //注册协议
    Route::post('/agreement','RegisterController@agreement')->name('register.agreement');
    //登录
    Route::post('/login','LoginController@login')->name('login.login');
    //绑定微信
    Route::post('/bind','BindController@bind')->name('bind.bind');
    //首页
    Route::post('/home','HomeController@index')->name('home.index');
    //重置密码
    Route::post('/reset-password','ResetPasswordController@resetPassword')->name('reset.reset-password');
    //版本检查
    Route::post('/version/check','VersionController@check')->name('version.check');
    //关于我们
    Route::post('/about','AboutUsController@show')->name('about.show');
    //需要登录才能访问的接口
    Route::group(['middleware' => ['auth:api']], function () {
        //商品
        Route::post('/good','GoodController@index')->name('good.index');
        //地址数据
        Route::post('/address','AddressController@index')->name('address.index');
        //添加地址
        Route::post('/address/store','AddressController@store')->name('address.store');
        //编辑地址
        Route::post('/address/update/{address}','AddressController@update')->name('address.update');
        //订单列表
        Route::post('/order','OrderController@index')->name('order.index');
        Route::post('/order/show/{order}','OrderController@show')->name('order.show');
        //确认收货
        Route::post('/order/confirm/{order}','OrderController@confirm')->name('order.confirm');
        //物流详情
        Route::post('/order/express/{order}','ExpressController@index')->name('express.index');
        //下单
        Route::post('/order/store/{good}/{address}','OrderController@store')->name('order.store');
        //支付
        Route::post('/pay/{order}','PayController@pay')->name('pay.pay');
        //支付异步通知
        Route::post('/pay/notify','PayController@notify')->name('pay.notify');
        Route::post('/pay/wx-notify','PayController@wxNotify')->name('pay.wx-notify');
        //资金记录
        Route::post('/balance/detail','BalanceDetailController@index')->name('balance.index');
        //申请提现
        Route::post('/withdraw','WithdrawController@withdraw')->name('withdraw.withdraw');
        //我的团队
        Route::post('/user/invites','UserController@invites')->name('user.invites');
        //修改密码
        Route::post('/user/modify-password','UserController@modifyPassword')->name('user.modify-password');
    });
});
