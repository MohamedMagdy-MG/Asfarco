<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserAddressesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_addresses', function (Blueprint $table) {
            $table->id();
            $table->string('uuid', 9)->unique();
            $table->string('label')->nullable();
            $table->text('address')->nullable();
            $table->unsignedBigInteger('city_id')->nullable();
            $table->foreign('city_id')->on('cities')->references('id')->onDelete('CASCADE')->onUpdate('CASCADE');
            $table->string('user_id')->nullable();
            $table->foreign('user_id')->on('users')->references('uuid')->onDelete('CASCADE')->onUpdate('CASCADE');
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
        Schema::dropIfExists('user_addresses');
    }
}
