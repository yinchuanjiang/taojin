<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGoodsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('goods', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title')->comment('商品标题');
            $table->decimal('price',10,2)->comment('价格');
            $table->integer('sales_volume')->comment('销量')->default(0);
            $table->longText('describe')->nullable()->commnet('描述');
            $table->tinyInteger('status')->default(\App\Models\Enum\GoodEnum::NORMAL)->comment('状态');
            $table->integer('stock')->default(0)->comment('库存');
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
        Schema::dropIfExists('goods');
    }
}
