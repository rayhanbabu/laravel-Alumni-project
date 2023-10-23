<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOnlinepaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('onlinepayments', function (Blueprint $table) {
            $table->id();
            $table->string('admin_name');
            $table->string('des1')->nullable();
            $table->string('des2')->nullable();
            $table->string('des3')->nullable();
            $table->integer('amount1')->default(0);
            $table->integer('amount2')->default(0);
            $table->integer('amount3')->default(0);
            $table->integer('payment');
            $table->string('status')->nullable();
            $table->string('type')->nullable();
            $table->integer('subscribe')->nullable();
            $table->integer('payment_duration')->nullable();
            $table->date('created_date');
            $table->date('expired_date');
            $table->string('payment_type')->nullable();
            $table->timestamp('payment_time')->nullable();
            $table->string('payment_date')->nullable();
            $table->string('payment_year')->nullable();
            $table->string('payment_month')->nullable();
            $table->string('payment_day')->nullable();
            $table->string('others')->nullable();
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
        Schema::dropIfExists('onlinepayments');
    }
}
