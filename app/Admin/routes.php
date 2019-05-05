<?php

use Illuminate\Routing\Router;

Admin::registerAuthRoutes();

Route::group([
    'prefix'        => config('admin.route.prefix'),
    'namespace'     => config('admin.route.namespace'),
    'middleware'    => config('admin.route.middleware'),
], function (Router $router) {
    $router->get('/', 'HomeController@index')->name('admin.home');
    $router->resource('banners', BannerController::class);
    $router->resource('goods', GoodController::class);
    $router->resource('good-images', GoodImgController::class);
    $router->resource('orders', OrderController::class);
    $router->resource('users', UserController::class);
});
