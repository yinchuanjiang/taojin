<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWithdrawsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('withdraws', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('user_id')->comment('用户id');
            $table->decimal('cash',10,2)->comment('提现金额');
            $table->string('account')->comment('提现账户');
            $table->string('bank_of_deposit')->nullable()->comment('开户行');
            $table->string('status',4)->comment('状态')->default(\App\Models\Enum\WithdrawEnum::APPLY);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('withdraws');
    }
}
