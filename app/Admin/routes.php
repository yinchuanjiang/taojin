<?php

use Illuminate\Routing\Router;

Admin::registerAuthRoutes();

Route::group([
    'prefix'        => config('admin.route.prefix'),
    'namespace'     => config('admin.route.namespace'),
    'middleware'    => config('admin.route.middleware'),
], function (Router $router) {
    $router->get('/',function (){
        return redirect('/admin/orders');
    });
    $router->resource('banners', BannerController::class);
    $router->resource('goods', GoodController::class);
    $router->resource('orders', OrderController::class);
    $router->resource('users', UserController::class);
    $router->resource('withdraws', WithdrawController::class);
    $router->resource('configs', ConfigController::class);
    $router->resource('balance-details', BalanceDetailController::class);
});
