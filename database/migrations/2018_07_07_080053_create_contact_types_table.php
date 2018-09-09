<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateContactTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contact_types', function (Blueprint $table) {
            $table->increments('id');
            $table->string('icon');
            $table->string('name');
            $table->timestamps();
        });

        // Insert master data
        DB::table('contact_types')->insert([
            [
                'icon' => 'contact-type-call-icon',
                'name' => 'call'
            ],
            [
                'icon' => 'contact-type-message-icon',
                'name' => 'message'
            ],
            [
                'icon' => 'contact-type-facebook-icon',
                'name' => 'facebook'
            ],
            [
                'icon' => 'contact-type-twitter-icon',
                'name' => 'twitter'
            ],
            [
                'icon' => 'contact-type-other-icon',
                'name' => 'others'
            ],
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('contact_types');
    }
}
