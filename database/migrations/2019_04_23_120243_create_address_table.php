<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAddressTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('address', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('user_id')->comment('用户id');
            $table->string('to_name')->comment('收件人');
            $table->string('mobile',11)->comment('电话');
            $table->string('address')->comment('省+市+区');
            $table->string('detail')->comment('详细地址');
            $table->string('postcode',6)->nnullable()->comment('邮政编码');
            $table->timestamps();
            $table->foreign('user_id')->references('id')->on('users');
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
        Schema::dropIfExists('address');
    }
}
