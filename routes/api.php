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
    //登录
    Route::post('/login','LoginController@login')->name('login.login');
    //绑定微信
    Route::post('/bind','BindController@bind')->name('bind.bind');
    //需要登录才能访问的接口
    Route::group(['middleware' => ['auth:api']], function () {
        //首页
        Route::post('/home','HomeController@index')->name('home.index');
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
        //下单
        Route::post('/order/store','OrderController@store')->name('order.store');
    });
});
