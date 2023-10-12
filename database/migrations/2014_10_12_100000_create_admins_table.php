<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdminsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('admins', function (Blueprint $table) {
            $table->id();
            $table->string('uuid', 9)->unique();
            $table->string('name_en');
            $table->string('name_ar');
            $table->string('email')->unique();
            $table->string('password');
            $table->enum('gender',['Male','Female','Other']);
            $table->string('image')->nullable();
            $table->enum('language',['AR','EN'])->default('EN');
            $table->enum('role',['Admin','Manager','Branch Manager','Branch Employee'])->default('Admin');
            $table->text('firebasetoken')->nullable();
            $table->boolean('active')->default(true); 
            $table->string('otp')->nullable();
            $table->timestamp('Verify_at')->nullable(); 
            $table->timestamp('email_verified_at')->nullable();
            $table->string('branch_id')->nullable();
            $table->foreign('branch_id')->on('branches')->references('uuid')->onDelete('CASCADE')->onUpdate('CASCADE');
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
        Schema::dropIfExists('admins');
    }
}
