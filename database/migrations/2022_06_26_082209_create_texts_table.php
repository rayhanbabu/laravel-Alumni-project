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
        Schema::create('texts', function (Blueprint $table) {
             $table->id();
             $table->string('lang')->nullable();
             $table->string('image')->nullable();
             $table->string('admin_name');
             $table->string('name');
             $table->text('workplace');
             $table->text('current_address')->nullable();
             $table->text('permanent_address')->nullable();
             $table->string('blood')->nullable();
             $table->integer('bloodno')->nullable();
             $table->date('blood_date')->nullable();
             $table->string('blood_status')->nullable();
             $table->string('phone')->nullable();
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
        Schema::dropIfExists('texts');
    }
};
