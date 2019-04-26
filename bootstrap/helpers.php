<?php
/**
 * Created by PhpStorm.
 * User: yinchuanjiang
 * Date: 2018/10/19
 * Time: 下午2:24
 */
//自定义全局函数返回接口数据
if (! function_exists('show')) {
    /**
     * @param $status
     * @param string $msg
     * @param array $data
     * @return array
     */
    function show($status = \App\Http\Core\Core::HTTP_SUCCESS_CODE, $msg = '',$data = [])
    {
        return new \Illuminate\Http\JsonResponse(compact('status','msg','data'));
    }
}

//生成订单号
if (! function_exists('makeSn')) {
    function makeSn(){
        return time().rand(1000000,9999999);
    }
}