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
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->string('admin_name');
            $table->unsignedBigInteger('member_id');
            $table->unsignedBigInteger('category_id');

            $table->foreign('member_id')->references('id')->on('members')->restrictOnDelete()
               ->cascadeOnUpdate();

            $table->foreign('category_id')->references('id')->on('apps')->restrictOnDelete()
              ->cascadeOnUpdate();

            $table->float('amount');
            $table->float('getway_fee');
            $table->float('total_amount');
            $table->string('tran_id')->default('null');
            $table->enum('payment_status',['0','1',])->default(0);
            $table->enum('payment_type',['Online','Offline',])->nullable();
            $table->timestamp('payment_time')->nullable();
            $table->string('payment_method')->nullable();
            $table->date('payment_date')->nullable();
            $table->integer('payment_year')->nullable();
            $table->integer('payment_month')->nullable();
            $table->integer('payment_day')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invoices');
    }
};
