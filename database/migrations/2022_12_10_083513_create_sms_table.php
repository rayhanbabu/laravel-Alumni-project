<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSmsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sms', function (Blueprint $table) {
             $table->id();
             $table->string('admin_name');
             $table->string('sms_type');
             $table->integer('sms_count');
             $table->string('class')->nullable();
             $table->string('babu')->nullable();
             $table->string('section')->nullable();
             $table->string('others1')->nullable();
             $table->string('others2')->nullable();
             $table->string('subject')->nullable();
             $table->string('text')->nullable();
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
        Schema::dropIfExists('sms');
    }
}
