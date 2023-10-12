<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCarAdditionalFeaturesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('car_additional_features', function (Blueprint $table) {
            $table->id();
            $table->string('uuid', 9)->unique();
            $table->string('name_en')->nullable();
            $table->string('name_ar')->nullable();
            $table->double('price')->default(0.00);
            $table->string('car_id')->nullable();
            $table->foreign('car_id')->on('cars')->references('uuid')->onDelete('CASCADE')->onUpdate('CASCADE');
            $table->softDeletes();
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
        Schema::dropIfExists('car_additional_features');
    }
}
