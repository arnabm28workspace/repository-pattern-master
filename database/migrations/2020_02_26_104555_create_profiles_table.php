<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProfilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('profiles', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id');
            $table->string('company_name')->nullable();
            $table->string('company_registration_number')->nullable();
            $table->string('company_vat_number')->nullable();
            $table->string('post_code')->nullable();
            $table->string('phone_number')->nullable();
            $table->string('website_url')->nullable();
            $table->boolean('notification_newsletter')->default(false);
            $table->boolean('notification_repost')->default(false);
            $table->boolean('is_profile_complete')->default(false);
            $table->timestamps();
            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('profiles');
    }
}
