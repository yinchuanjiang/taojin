<?php

namespace App\Http\Controllers\Api;

use App\Http\Core\Core;
use App\Http\Requests\Api\VersionRequest;
use App\Http\Controllers\Controller;
use App\Models\Config;

class VersionController extends Controller
{
    //版本检查
    /**
     * @api {POST} version/check 版本检查
     * @apiSampleRequest version/check
     * @apiParam {String} type  类型(必填【'IOS','ANDROID'】)
     * @apiParam {String} version 版本号(必填)
     * @apiPermission 无
     * @apiName check
     * @apiGroup V-Version
     * @apiVersion 1.0.0
     * @apiDescription   api   版本检查
     * @apiSuccessExample Success-Response:
     *     HTTP/1.1 200 OK
     *     {
     *          "status":"200",
     *          "msg":"检查成功",
     *          "data":[
     *              "config":{
     *                  "update":"false:无需更新|big:大更新|small:小更新",
     *                  "value":"版本说明",
     *                  "hot_url":"热更新文件",
     *                  "url":"下载地址"，
     *              }
     *          ]
     *     }
     *
     *
     * @apiErrorExample Error-Response:
     *     HTTP/1.1 422 Not Found  422错误提示,请使用ajax异常扑获取
     *      {
     *          "message": "The given data was invalid.",
     *              "errors": {
     *                   "type": [
     *                       "type 不能为空。"
     *                   ]
     *               }
     *            }
     * @apiErrorExample Error-Response:
     *      {
     *          "status":"400",
     *          "msg":"错误提示",
     *          "data":[]
     *      }
     */
    public function check(VersionRequest $request)
    {
        $data = $request->all(['version','type']);
        $config = Config::where('name',$data['type'].'_VERSION')->select('id','value','version','url')->first();
        if($config->version == $data['version'])
            $config->update = false;
        $nowVersion = explode('.',$config->version);
        $useVersion = explode('.',$data['version']);
        if(count($nowVersion) != count($useVersion))
            return show(Core::HTTP_ERROR_CODE,'非法请求');
        if($nowVersion[0] > $useVersion[0] || $nowVersion[1] > $useVersion[1]){
            $config->update = 'big';
        }else if($config->version != $data['version']){
            $config->update = 'small';
        }
        $config->hot_url = '';
        return show(Core::HTTP_SUCCESS_CODE,'检查版本成功',compact('config'));
    }
}
