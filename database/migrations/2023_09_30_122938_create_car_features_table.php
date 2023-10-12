<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCarFeaturesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('car_features', function (Blueprint $table) {
            $table->id();
            $table->string('uuid', 9)->unique();
            $table->string('feature_id')->nullable();
            $table->foreign('feature_id')->on('features')->references('uuid')->onDelete('CASCADE')->onUpdate('CASCADE');
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
        Schema::dropIfExists('car_features');
    }
}
