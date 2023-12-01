<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNotificationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('notifications', function (Blueprint $table) {
            $table->id();
            $table->string('uuid', 9)->unique();
            $table->string('admin_id')->nullable();
            $table->foreign('admin_id')->on('admins')->references('uuid')->onDelete('CASCADE')->onUpdate('CASCADE');
            $table->string('model')->nullable();
            $table->string('title_en')->nullable();
            $table->string('title_ar')->nullable();
            $table->text('message_en')->nullable();
            $table->text('message_ar')->nullable();
            $table->boolean('is_read')->default(false);
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
        Schema::dropIfExists('notifications');
    }
}
