<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('mobile')->unique()->comment('手机号');
            $table->string('password')->nullable()->comment('密码');
            $table->string('avatar')->nullable()->comment('头像');
            $table->string('wx_oauth')->unique()->nullable()->comment('微信登录凭证');
            $table->unsignedInteger('visitor_id')->nullable()->comment('邀请人id');
            $table->decimal('balance',10,2)->default(0.00)->comment('余额');
            $table->tinyInteger('first_assist',1)->default(\App\Models\Enum\UserEnum::FIRST_ASSIST_FALSE)->comment('一级奖励助攻');
            $table->tinyInteger('second_assist',1)->default(\App\Models\Enum\UserEnum::SECOND_ASSIST_FALSE)->comment('二级奖励助攻');
            $table->timestamps();
            $table->engine = 'myisam';
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
