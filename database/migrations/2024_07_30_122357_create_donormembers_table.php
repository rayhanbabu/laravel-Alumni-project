<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('donormembers', function (Blueprint $table) {
             $table->id();
             $table->string('admin_name');
             $table->foreign('admin_name')->references('admin_name')->on('admins');
             $table->string('name');
             $table->string('email');
             $table->string('phone');
             $table->string('profile_image')->nullable();
             $table->string('designation')->nullable();
             $table->float('net_amount');
             $table->float('amount');
             $table->integer('getway_charge_status');
             $table->float('getway_fee');
             $table->float('total_amount');
             $table->string('tran_id')->unique();
             $table->string('payment_status')->default(0);
             $table->string('passing_year')->nullable();
             $table->string('address')->nullable();
             $table->enum('payment_type',['Online','Offline'])->nullable();
             $table->timestamp('payment_time')->nullable();
             $table->string('payment_method')->nullable();
             $table->date('payment_date')->nullable();
             $table->integer('payment_year')->nullable();
             $table->integer('payment_month')->nullable();
             $table->integer('payment_day')->nullable();
             $table->string('weblink')->nullable();
             $table->string('bank_tran')->nullable();
             $table->string('problem_status')->nullable();
             $table->string('problem_update_time')->nullable();
             $table->string('problem_update_by')->nullable();
             $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('donormembers');
    }
};
