<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Good extends Model
{
    protected $guarded = [];

    //关联图片
    public function goodImgs()
    {
        return $this->hasMany(GoodImg::class);
    }
}
