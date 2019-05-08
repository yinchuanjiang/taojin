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

    public function setPicturesAttribute($pictures)
    {
        if (is_array($pictures)) {
            $this->attributes['pictures'] = json_encode($pictures);
        }
    }

    public function getPicturesAttribute($pictures)
    {
        return json_decode($pictures, true);
    }
}
