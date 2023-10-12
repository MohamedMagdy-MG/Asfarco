<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBranchesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('branches', function (Blueprint $table) {
            $table->id();
            $table->string('uuid', 9)->unique();
            $table->string('name_en');
            $table->string('name_ar');
            $table->string('address_en');
            $table->string('address_ar');
            $table->string('longitude')->nullable();
            $table->string('latitude')->nullable();
            $table->boolean('active')->default(true); 
            $table->unsignedBigInteger('city_id')->nullable();
            $table->foreign('city_id')->on('cities')->references('id')->onDelete('CASCADE')->onUpdate('CASCADE');
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
        Schema::dropIfExists('branches');
    }
}
