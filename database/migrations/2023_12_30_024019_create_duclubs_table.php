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
        Schema::create('duclubs', function (Blueprint $table) {
            $table->id();
            $table->string('phone');
            $table->string('otp'); 
            $table->string('name');
            $table->string('member_id')->nullable();
            $table->string('member_card')->nullable();
            $table->string('designation')->nullable();
            $table->string('dept')->nullable();
            $table->string('email')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('duclubs');
    }
};
