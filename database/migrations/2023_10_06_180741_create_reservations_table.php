<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReservationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        
        Schema::create('reservations', function (Blueprint $table) {
            $table->id();
            $table->string('uuid', 9)->unique();
            $table->dateTime('pickup');
            $table->dateTime('return');
            $table->string('car_id')->nullable();
            $table->foreign('car_id')->on('cars')->references('uuid')->onDelete('CASCADE')->onUpdate('CASCADE');
            $table->string('user_id')->nullable();
            $table->foreign('user_id')->on('users')->references('uuid')->onDelete('CASCADE')->onUpdate('CASCADE');
            $table->enum('mode',['Daily','Weekly','Monthly'])->default('Daily');
            $table->enum('payment_mode',['Cash','Visa','Bitcoin'])->default('Cash');
            $table->enum('status',['Pending','Ongoing','Completed','Cancelled'])->default('Pending');
            $table->dateTime('cancelled_on')->nullable();
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
        Schema::dropIfExists('reservations');
    }
}
