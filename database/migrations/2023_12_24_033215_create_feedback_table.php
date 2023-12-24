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
        Schema::create('feedback', function (Blueprint $table) {
             $table->id();
             $table->string('admin_name');
             $table->unsignedBigInteger('member_id');
             $table->foreign('member_id')->references('id')->on('members')->restrictOnDelete()
                  ->cascadeOnUpdate();
             $table->string('tran_id');
             $table->string('subject'); 
             $table->text('text')->nullable();  
             $table->string('feedback_status')->default(0);  
             $table->string('feedback')->nullable();
             $table->string('image')->nullable();    
             $table->timestamp('updated_by_time')->nullable();
             $table->string('updated_by')->nullable(); 

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('feedback');
    }
};
