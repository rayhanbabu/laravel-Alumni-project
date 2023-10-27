<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMembersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('members', function (Blueprint $table) {
            $table->id();
            $table->integer('serial');
            $table->string('admin_name');
            $table->string('category');
            $table->integer('member_card');
            $table->string('name');
            $table->string('email');
            $table->string('emailmd5');
            $table->string('phone');
            $table->string('member_password');
            $table->enum('degree_category',['Honours','Masters','PhD']);
            $table->string('email_verify')->default(0);
            $table->string('member_verify')->default(0);
            $table->string('status')->default(1);
            $table->string('passing_year')->nullable();
            $table->string('certificate_image')->nullable();
            $table->string('gender')->nullable();
            $table->string('lang')->nullable();
            $table->string('profile_image')->nullable();
            $table->date('birth_date')->nullable();
            $table->string('blood')->nullable();
            $table->string('country')->nullable();
            $table->string('city')->nullable();
            $table->string('occupation')->nullable();
            $table->string('organization')->nullable();
            $table->string('designation')->nullable();
            $table->string('blood_status')->nullable();
            $table->string('phone_status')->nullable();
            $table->string('email_status')->nullable();
            $table->string('fb_link')->nullable();
            $table->string('youtube_link')->nullable();
            $table->string('web_link')->nullable();
            $table->string('text1')->nullable();
            $table->string('text2')->nullable();
            $table->string('text3')->nullable();
            $table->string('text4')->nullable();
            $table->text('affiliation')->nullable();
            $table->text('training')->nullable();
            $table->text('expertise')->nullable();
            $table->string('forget_code')->nullable();
            $table->string('forget_time')->nullable();
            $table->string('login_code')->nullable();
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
        Schema::dropIfExists('members');
    }
}
