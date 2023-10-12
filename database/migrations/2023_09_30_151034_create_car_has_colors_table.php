<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCarHasColorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('car_has_colors', function (Blueprint $table) {
            $table->id();
            $table->string('uuid', 9)->unique();
            $table->string('color_id')->nullable();
            $table->foreign('color_id')->on('car_colors')->references('uuid')->onDelete('CASCADE')->onUpdate('CASCADE');
            $table->string('car_id')->nullable();
            $table->foreign('car_id')->on('cars')->references('uuid')->onDelete('CASCADE')->onUpdate('CASCADE');
            $table->integer('total')->default(0);
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
        Schema::dropIfExists('car_has_colors');
    }
}
