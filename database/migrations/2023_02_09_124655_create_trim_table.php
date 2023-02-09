<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTrimTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('trims', function (Blueprint $table) {
            $table->id('trim_id');
            $table->string('name');
            $table->unsignedBigInteger('model_id')->comment("model");
            $table->foreign('model_id')->references('model_id')->on('models');
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
        Schema::dropIfExists('trims');
    }
}
