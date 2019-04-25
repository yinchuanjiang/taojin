<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHomeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('home', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title')->comment('标题');
            $table->longText('content')->comment('内容');
            $table->tinyInteger('status')->comment('状态')->default(\App\Models\Enum\HomeEnum::NORMAL);
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
        Schema::dropIfExists('home');
    }
}
