<?php

namespace App\Models;

use Laravel\Passport\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Encore\Admin\Traits\AdminBuilder;
use Encore\Admin\Traits\ModelTree;

class User extends Authenticatable
{
    use Notifiable, HasApiTokens, ModelTree, AdminBuilder;

    protected $guarded = [];

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        $this->setParentColumn('invite_id');
        $this->setOrderColumn('id');
        $this->setTitleColumn('mobile');
    }

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
    ];

    //修改passport 验证字段
    public function findForPassport($username)
    {
        return $this->orWhere('mobile', $username)->first();
    }
    //修改password字段
    public function validateForPassportPasswordGrant($password)
    {
        //如果请求密码等于数据库密码 返回true（此为实例，根据自己需求更改）
        /**
        if($password == $this->password){
        return true;
        }
        return false;
         **/
        return true;
    }

    //关联 地址
    public function address()
    {
        return $this->hasMany(Address::class);
    }
    //关联 订单
    public function orders()
    {
        return $this->hasMany(Order::class);
    }
    //关联推荐者
    public function inviter()
    {
        return $this->belongsTo(User::class,'invite_id','id');
    }
    //关联我推荐的人
    public function invites()
    {
        return $this->hasMany(User::class,'invite_id','id');
    }
    //关联下级
    public function underless()
    {
        return $this->hasMany(User::class,'invite_id','id');
    }

    //关联金额记录
    public function balanceDetails()
    {
        return $this->hasMany(BalanceDetail::class);
    }

    //我的提现
    public function withdraws()
    {
        return $this->hasMany(Withdraw::class);
    }
}
