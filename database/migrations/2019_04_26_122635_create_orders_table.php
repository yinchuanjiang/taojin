<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('user_id');
            $table->unsignedInteger('good_id');
            $table->string('sn',20)->comment('订单编号');
            $table->integer('quantity')->comment('数量');
            $table->decimal('total',10,2)->comment('总价格');
            $table->tinyInteger('status')->default(\App\Models\Enum\OrderEnum::PAYING)->comment('状态');
            $table->string('pay_type',4)->nullable()->comment('支付方式');
            $table->unsignedInteger('express_id')->comment('物流id')->nullable();
            $table->string('express_code')->comment('快递单号')->nullable();
            $table->json('address')->comment('收货地址');
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
        Schema::dropIfExists('orders');
    }
}
