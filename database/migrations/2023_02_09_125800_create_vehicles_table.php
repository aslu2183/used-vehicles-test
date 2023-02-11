<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVehiclesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vehicles', function (Blueprint $table) {
            $table->id('vehicle_id');
            $table->string('name');
            $table->unsignedBigInteger('category_id')->comment("cateogry");
            $table->foreign('category_id')->references('category_id')->on('categories');
            $table->unsignedBigInteger('brand_id')->comment("brand")->nullable();
            $table->foreign('brand_id')->references('brand_id')->on('brands');
            $table->unsignedBigInteger('model_id')->comment("model")->nullable();
            $table->foreign('model_id')->references('model_id')->on('models');
            $table->unsignedBigInteger('trim_id')->comment("trim")->nullable();
            $table->foreign('trim_id')->references('trim_id')->on('trims');
            $table->longText('vehicle_image')->nullable();
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
        Schema::dropIfExists('vehicles');
    }
}
