<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('testimonials', function (Blueprint $table) {
             $table->id();
             $table->integer('serial');
             $table->string('lang')->nullable();
             $table->string('image')->nullable();
             $table->string('admin_name');
             $table->string('category');
             $table->string('name');
             $table->text('workplace');
             $table->text('current_address')->nullable();
             $table->text('permanent_address')->nullable();
             $table->string('blood')->nullable();
             $table->string('blood_status')->nullable();
             $table->string('phone')->nullable();
             $table->string('phone_status')->nullable();
             $table->string('email')->nullable();
             $table->string('email_status')->nullable();
             $table->string('fb_link')->nullable();
             $table->string('youtube_link')->nullable();
             $table->string('web_link')->nullable();
             $table->string('text1')->nullable();
             $table->string('text2')->nullable();
             $table->string('text3')->nullable();
             $table->string('text4')->nullable();
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
        Schema::dropIfExists('testimonials');
    }
};
