<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('uuid', 9)->unique();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('mobile')->unique();
            $table->string('password');
            $table->enum('gender',['Male','Female','Other']);
            $table->string('image')->nullable();

            $table->enum('language',['AR','EN'])->default('EN');
            $table->string('longitude')->nullable();
            $table->string('latitude')->nullable();
            $table->text('firebasetoken')->nullable();

            $table->enum('register_type',['Email','Apple','Gmail'])->default('Email');

           
            $table->unsignedBigInteger('country_id')->nullable();
            $table->foreign('country_id')->on('countries')->references('id')->onDelete('CASCADE')->onUpdate('CASCADE');
            
            $table->boolean('active')->default(true); 
            $table->boolean('verify_document')->default(true); 
            $table->timestamp('verify_document_at')->nullable(); 
    
            $table->timestamp('email_verified_at')->nullable();

            $table->string('otp')->nullable();
            $table->timestamp('Verify_at')->nullable(); 

            $table->string('otp_reset')->nullable();
            $table->timestamp('Reset_at')->nullable(); 

            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
