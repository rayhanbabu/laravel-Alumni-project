<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateExpresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('expres', function (Blueprint $table) {
            $table->id();
            $table->string('lang')->nullable();
            $table->string('image')->nullable();
            $table->string('serial');
            $table->string('admin_name');
            $table->string('name');
            $table->string('category');
            $table->string('date1')->nullable();
            $table->string('date2')->nullable();
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
        Schema::dropIfExists('expres');
    }
}
