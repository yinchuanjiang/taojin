<?php

namespace App\Models;

use App\Models\Enum\BalanceDetailEnum;
use App\Models\Enum\WithdrawEnum;
use Illuminate\Database\Eloquent\Model;

class Withdraw extends Model
{
    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public static function boot()
    {
        parent::boot();

        static::saved(function ($model) {
            // 从$model取出数据并进行处理
            //提现成功
            if($model->status == WithdrawEnum::SUCCESS){
                $balanceDetail = BalanceDetail::where('withdraw_id',$model->id)->first();
                if($balanceDetail)
                    return;
                BalanceDetail::create([
                    'user_id' => $model->user_id,
                    'withdraw_id' => $model->id,
                    'type' => BalanceDetailEnum::WITHDRAW_CASH,
                    'cash' => $model->cash,
                    'before_balance' => $model->user->balance + $model->cash,
                    'after_balance' => $model->user->balance
                ]);
            }
            //提现失败
            if($model->status == WithdrawEnum::INVALID){
                $model->user->balance += $model->cash;
                $model->user->save();
            }
        });
    }
}
