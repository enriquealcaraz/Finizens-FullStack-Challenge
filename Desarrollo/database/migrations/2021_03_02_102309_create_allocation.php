<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAllocation extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('allocation', function (Blueprint $table) {
            $table->integer('id');
            $table->integer('portfolio');
            $table->integer('shares');            
        });
        
        DB::table("allocation")->insert(
            [
                "id" => 1,
                "portfolio" => 1,                
                "shares" => 3 
            ]
        );
        
        DB::table("allocation")->insert(
            [
                "id" => 2,
                "portfolio" => 1,                
                "shares" => 4 
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
        Schema::dropIfExists('allocation');
    }
}
