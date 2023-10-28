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
        Schema::create('amarpays', function (Blueprint $table) {
            $table->id();
            $table->string('admin_name');
            $table->unsignedBigInteger('cus_add1');
            $table->unsignedBigInteger('cus_add2');

            $table->foreign('cus_add1')->references('id')->on('members')->restrictOnDelete()
               ->cascadeOnUpdate();

            $table->foreign('cus_add2')->references('id')->on('invoices')->restrictOnDelete()
              ->cascadeOnUpdate();

              $table->string('store_id');
              $table->string('signature_key');
              $table->float('amount');
              $table->string('currency');
              $table->string('desc');
              $table->string('cus_name');
              $table->string('cus_email');
              $table->string('cus_phone');
              $table->string('success_url');
              $table->string('fail_url');
              $table->string('cancel_url');
              $table->string('type');



            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('amarpays');
    }
};
