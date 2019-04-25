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
