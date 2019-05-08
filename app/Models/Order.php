<?php

namespace App\Models;

use App\Models\Enum\OrderEnum;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $guarded = [];

    //关联
    public function good()
    {
        return $this->belongsTo(Good::class);
    }
    //关联 用户
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    //关联快递
    public function express()
    {
        return $this->belongsTo(Express::class);
    }
    //搜索
    public function scopeSearch(Builder $query)
    {
        $status = request('status',-2);
        if(in_array($status,[OrderEnum::CANCEL,OrderEnum::PAYED,OrderEnum::POSTED,OrderEnum::FINISH,OrderEnum::PAYING])){
            $query->where('status',$status);
        }
        return $query;
    }
}
