<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('admins', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('nameen');
            $table->string('address');
            $table->string('email');
            $table->string('email2');
            $table->float('getway_fee')->default(0);
            $table->float('offline_amount')->default(0);
            $table->float('online_amount')->default(0);
            $table->float('online_withdraw')->default(0);
            $table->float('online_cur_amount')->default(0);
            $table->float('sponsor_amount')->default(0);
            $table->float('total_amount')->default(0);
            $table->float('spent')->default(0);
            $table->float('reserve_amount')->default(0);
            $table->string('email_verify')->nullable();
            $table->string('mobile');
            $table->string('admin_name');
            $table->string('admin_password');
            $table->string('role');
            $table->string('version_type');
            $table->string('status')->nullable();
            $table->integer('payment')->nullable();
            $table->string('forget_code')->nullable();
            $table->string('forget_time')->nullable();
            $table->date('created_date')->nullable();
            $table->date('expired_date')->nullable();
            $table->integer('subscribe')->nullable();
            $table->integer('payment_duration')->nullable();
            $table->string('image')->nullable();
            $table->integer('magazine_size')->nullable();
            $table->integer('member_size')->nullable();
            $table->integer('executive_size')->nullable();
            $table->integer('senior_size')->nullable();
            $table->integer('general_size')->nullable();
            $table->integer('notice_size')->nullable();
            $table->integer('welcome_size')->nullable();
            $table->integer('testimonial_size')->nullable();
            $table->integer('slide_size')->nullable();
            $table->integer('blood_size')->nullable();
            $table->integer('advisor_size')->nullable();
            $table->integer('sms_access')->nullable();
            $table->integer('header_size')->nullable();
            $table->integer('resheader_size')->nullable();
            $table->text('text1')->nullable();
            $table->text('text2')->nullable();
            $table->text('text3')->nullable();
            $table->text('text4')->nullable();
            $table->text('text5')->nullable();
            $table->text('fb_link')->nullable();
            $table->string('youtube_link')->nullable();
            $table->string('other_link')->nullable();
            $table->integer('available_sms')->default(0);
            $table->string('registration')->nullable();
            $table->string('header')->nullable();
            $table->string('footer')->nullable();
            $table->string('formname')->nullable();
            $table->string('phone')->nullable();
            $table->string('custom1')->nullable();
            $table->string('custom2')->nullable();
            $table->string('custom3')->nullable();
            $table->string('custom4')->nullable();
            $table->string('custom5')->nullable();
            $table->string('custom6')->nullable();
            $table->string('custom7')->nullable();
            $table->string('custom8')->nullable();
            $table->string('custom9')->nullable();
            $table->string('custom10')->nullable();
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
        Schema::dropIfExists('admins');
    }
};
