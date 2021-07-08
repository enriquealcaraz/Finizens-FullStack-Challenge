<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrder extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order', function (Blueprint $table) {
            $table->integer('id');
            $table->integer('portfolio');
            $table->integer('allocation');
            $table->integer('shares');
            $table->string('type');
            $table->boolean('status');
        });
        
        DB::table("order")->insert(
            [
                "id" => 1,
                "portfolio" => 1,
                "allocation" => 3,
                "shares" => 3,
                "type" => "buy",
                "status" => 0
            ]
        );        
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('order');
    }
}
