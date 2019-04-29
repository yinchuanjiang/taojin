<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Core\Core;
use App\Http\Resources\Api\BannerResource;
use App\Http\Resources\Api\HomeResource;
use App\Models\Banner;
use App\Models\Enum\BannerEnum;
use App\Models\Enum\HomeEnum;
use App\Models\Home;

class HomeController extends Controller
{
    /**
     * @api {POST} home 首页
     * @apiSampleRequest home
     * @apiPermission 无
     * @apiName home
     * @apiGroup D-home
     * @apiVersion 1.0.0
     * @apiDescription   api   首页接口
     * @apiSuccessExample Success-Response:
     *     HTTP/1.1 200 OK
     *     {
     *          "status":"200",
     *          "msg":"获取成功",
     *          "data":[
     *              "banners":[
     *                  {
     *                      "id":"id",
     *                      "img_url":"图片url",
     *                  }
     *              ],
     *              "home":{
     *                  "id":"id"
     *                  "content":"内容",
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
    public function index()
    {
        $home = new HomeResource(Home::where('status',HomeEnum::NORMAL)->first());
        $banners = BannerResource::collection(Banner::where('status',BannerEnum::NORMAL)->get());
        return show(Core::HTTP_SUCCESS_CODE,'获取成功',compact('home','banners'));
    }
}
