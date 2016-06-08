<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableUserProfile extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_profile', function (Blueprint $table) {
           $table->increments('id');
           $table->integer('user_id')->unsigned();
           $table->string('slug', 128);
           $table->text('avatar_image');
           $table->text('cover_image');
           $table->string('first_name', 32);
           $table->string('last_name', 32);
           $table->date('day_of_birth')->nullable();
           $table->string('marital_status');
           $table->integer('country_id')->unsigned()->nullable();
           $table->integer('city_id')->unsigned()->nullable();
           $table->integer('district_id')->unsigned()->nullable();
           $table->integer('ward_id')->unsigned()->nullable();
           $table->string('street_name', 250);
           $table->integer('gender_id')->unsigned()->nullable();
           $table->string('phone_number', 16);
           $table->boolean('publish');
           $table->timestamps();
           
           
           $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
           $table->foreign('country_id')->references('id')->on('countries')->onDelete('cascade');
           $table->foreign('city_id')->references('id')->on('cities')->onDelete('cascade');
           $table->foreign('district_id')->references('id')->on('districts')->onDelete('cascade');
           $table->foreign('ward_id')->references('id')->on('wards')->onDelete('cascade');
           $table->foreign('gender_id')->references('id')->on('genders')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_profile');
    }
}
