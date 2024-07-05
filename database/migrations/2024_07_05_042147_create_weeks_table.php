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
        Schema::create('weeks', function (Blueprint $table) {
            $table->id();
            $table->string('admin_name');
            $table->foreign('admin_name')->references('admin_name')->on('admins');
            $table->string('image')->nullable();
            $table->integer('serial');
            $table->string('category_name');
            $table->string('week');
            $table->text('text')->nullable();
            $table->text('text2')->nullable();
            $table->text('text3')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('weeks');
    }
};
