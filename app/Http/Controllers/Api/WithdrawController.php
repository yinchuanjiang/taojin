<?php

namespace App\Http\Controllers\Api;


use App\Http\Core\Core;
use App\Http\Requests\Api\WithdrawRequest;
use App\Models\Withdraw;

class WithdrawController extends ApiBaseController
{
    //提现申请
    /**
     * @api {POST} withdraw 提现申请
     * @apiSampleRequest withdraw
     * @apiParam {Number} cash             金额(必填)
     * @apiParam {String} account          账户(必填)
     * @apiParam {String} real_name        姓名(必填)
     * @apiParam {String} bank_of_deposit  开户行(选填)
     * @apiHeader {String} authorization Authorization value.
     * @apiPermission 无
     * @apiName withdraw/withdraw
     * @apiGroup I-Withdraw
     * @apiVersion 1.0.0
     * @apiDescription   api   提现申请
     * @apiSuccessExample Success-Response:
     *     HTTP/1.1 200 OK
     *     {
     *          "status":"200",
     *          "msg":"申请成功",
     *          "data":[]
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
    public function withdraw(WithdrawRequest $request)
    {
        $data = $request->all(['cash','account','real_name','bank_of_deposit']);
        if($this->user->balance < $data['cash'])
            return show(Core::HTTP_ERROR_CODE,'余额不足');
        $this->user->balace = $this->user->balance - $data['cash'];
        $this->user->save();
        $this->user->withdraws()->save(new Withdraw($data));
        return show(Core::HTTP_SUCCESS_CODE,'申请成功');
    }
}
