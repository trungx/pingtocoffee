<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('account_id')->unsigned();
            $table->string('first_name');
            $table->string('last_name')->nullable();
            $table->string('email');
            $table->string('password');
            $table->text('description')->nullable();
            $table->rememberToken();
            $table->string('timezone')->default('UTC');
            $table->string('locale')->default('en');
            $table->date('birthday')->nullable();
            $table->string('gender', 10)->default('none');
            $table->boolean('has_avatar')->default(false);
            $table->string('avatar_file_name')->nullable();
            $table->string('avatar_location')->default('local');
            $table->string('default_avatar_color')->nullable();
            $table->string('referral_code')->nullable();
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
        Schema::dropIfExists('users');
    }
}
