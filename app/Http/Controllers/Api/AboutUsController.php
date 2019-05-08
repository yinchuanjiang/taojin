<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Core\Core;
use App\Models\Enum\ConfigEnum;

class AboutUsController extends Controller
{
    //关于我们和客服文案
    /**
     * @api {POST} about 关于我们和客服文案
     * @apiSampleRequest about
     * @apiHeader {String} authorization Authorization value.
     * @apiPermission 无
     * @apiName about
     * @apiGroup A-About
     * @apiVersion 1.0.0
     * @apiDescription   api   关于我们和客服文案
     * @apiSuccessExample Success-Response:
     *     HTTP/1.1 200 OK
     *     {
     *          "status":"200",
     *          "msg":"获取成功",
     *          "data":{
     *              "help":"客服帮助文案"
     *              "tel":"客服电话"
     *              "about":"关于我们文案"
     *          }
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
    public function show()
    {
        $help = strip_tags(ConfigEnum::getValue("COMPANY_HELP"));
        $about = ConfigEnum::getValue('COMPANY_ABOUT_US');
        $tel = strip_tags(ConfigEnum::getValue('COMPANY_TEL'));
        return show(Core::HTTP_SUCCESS_CODE,'获取成功',compact('help','tel','about'));
    }
}
