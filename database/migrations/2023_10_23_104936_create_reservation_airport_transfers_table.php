<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReservationAirportTransfersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reservation_airport_transfers', function (Blueprint $table) {
            $table->id();
            $table->string('uuid', 9)->unique();
            $table->text('address')->nullable();
            $table->unsignedBigInteger('city_id')->nullable();
            $table->foreign('city_id')->on('cities')->references('id')->onDelete('CASCADE')->onUpdate('CASCADE');
            $table->string('reservation_id')->nullable();
            $table->foreign('reservation_id')->on('reservations')->references('uuid')->onDelete('CASCADE')->onUpdate('CASCADE');
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
        Schema::dropIfExists('reservation_airport_transfers');
    }
}
