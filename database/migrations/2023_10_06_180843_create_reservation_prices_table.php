<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReservationPricesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */


    public function up()
    {
        Schema::create('reservation_prices', function (Blueprint $table) {
            $table->id();
            $table->string('uuid', 9)->unique();
            $table->double('price')->default(0.00);
            $table->integer('discount')->default(0);
            $table->double('price_after_discount')->default(0.00);
            $table->double('total')->default(0.00);
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
        Schema::dropIfExists('reservation_prices');
    }
}
