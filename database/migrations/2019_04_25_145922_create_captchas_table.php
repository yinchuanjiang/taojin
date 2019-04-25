<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCaptchasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('captchas', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('type')->default(\App\Http\Core\Core::DOCTOR_LOGIN_CAPTCHA);
            $table->string('mobile',11)->comment('手机号');
            $table->string('value',6)->comment('验证码字串');
            $table->tinyInteger('is_used')->default(\App\Http\Core\Core::CAPTCHA_USED_FALSE)->comment('是否使用 -1未使用 1使用');
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
        Schema::dropIfExists('captchas');
    }
}
