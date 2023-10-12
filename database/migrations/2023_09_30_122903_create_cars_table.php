<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCarsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cars', function (Blueprint $table) {
            $table->id();
            $table->string('uuid', 9)->unique();
            $table->string('name_en')->nullable();
            $table->string('name_ar')->nullable();
            $table->text('description_en')->nullable();
            $table->text('description_ar')->nullable();
            $table->boolean('active')->default(true); 
            $table->integer('bags')->default(0);
            $table->integer('passengers')->default(0);
            $table->integer('doors')->default(0);
            $table->double('daily')->default(0.00);
            $table->integer('daily_discount')->default(0);
            $table->double('weekly')->default(0.00);
            $table->integer('weekly_discount')->default(0);
            $table->double('monthly')->default(0.00);
            $table->integer('monthly_discount')->default(0);

            $table->string('category_id')->nullable();
            $table->foreign('category_id')->on('car_categories')->references('uuid')->onDelete('CASCADE')->onUpdate('CASCADE');
            
            $table->string('fuel_id')->nullable();
            $table->foreign('fuel_id')->on('fuel_types')->references('uuid')->onDelete('CASCADE')->onUpdate('CASCADE');

            $table->string('brand_id')->nullable();
            $table->foreign('brand_id')->on('car_brands')->references('uuid')->onDelete('CASCADE')->onUpdate('CASCADE');

            $table->string('model_id')->nullable();
            $table->foreign('model_id')->on('car_models')->references('uuid')->onDelete('CASCADE')->onUpdate('CASCADE');

            $table->string('model_year_id')->nullable();
            $table->foreign('model_year_id')->on('model_years')->references('uuid')->onDelete('CASCADE')->onUpdate('CASCADE');

            $table->string('transmission_id')->nullable();
            $table->foreign('transmission_id')->on('transmissions')->references('uuid')->onDelete('CASCADE')->onUpdate('CASCADE');

            $table->string('branch_id')->nullable();
            $table->foreign('branch_id')->on('branches')->references('uuid')->onDelete('CASCADE')->onUpdate('CASCADE');

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
        Schema::dropIfExists('cars');
    }
}
