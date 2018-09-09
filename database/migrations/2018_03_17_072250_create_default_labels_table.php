<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDefaultLabelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('default_labels', function (Blueprint $table) {
            $table->increments('id');
            $table->string('contact_field_type');
            $table->string('name');
            $table->timestamps();
        });

        DB::table('default_labels')->insert([
            // For phone
            [
                'contact_field_type' => \App\ContactField::CONTACT_TYPE_PHONE,
                'name' => 'mobile',
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now()
            ],
            [
                'contact_field_type' => \App\ContactField::CONTACT_TYPE_PHONE,
                'name' => 'home',
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now()
            ],
            [
                'contact_field_type' => \App\ContactField::CONTACT_TYPE_PHONE,
                'name' => 'work',
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now()
            ],
            [
                'contact_field_type' => \App\ContactField::CONTACT_TYPE_PHONE,
                'name' => 'home fax',
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now()
            ],
            [
                'contact_field_type' => \App\ContactField::CONTACT_TYPE_PHONE,
                'name' => 'work fax',
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now()
            ],
            [
                'contact_field_type' => \App\ContactField::CONTACT_TYPE_PHONE,
                'name' => 'other',
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now()
            ],

            // For address
            [
                'contact_field_type' => \App\ContactField::CONTACT_TYPE_EMAIL,
                'name' => 'home',
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now()
            ],
            [
                'contact_field_type' => \App\ContactField::CONTACT_TYPE_EMAIL,
                'name' => 'work',
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now()
            ],
            [
                'contact_field_type' => \App\ContactField::CONTACT_TYPE_EMAIL,
                'name' => 'other',
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now()
            ],

            // For email
            [
                'contact_field_type' => \App\ContactField::CONTACT_TYPE_ADDRESS,
                'name' => 'personal',
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now()
            ],
            [
                'contact_field_type' => \App\ContactField::CONTACT_TYPE_ADDRESS,
                'name' => 'company',
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now()
            ],
            [
                'contact_field_type' => \App\ContactField::CONTACT_TYPE_ADDRESS,
                'name' => 'other',
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now()
            ],

            // For social profile
            [
                'contact_field_type' => \App\ContactField::CONTACT_TYPE_SOCIAL_PROFILE,
                'name' => 'Facebook',
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now()
            ],
            [
                'contact_field_type' => \App\ContactField::CONTACT_TYPE_SOCIAL_PROFILE,
                'name' => 'Twitter',
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now()
            ],
            [
                'contact_field_type' => \App\ContactField::CONTACT_TYPE_SOCIAL_PROFILE,
                'name' => 'Instagram',
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now()
            ],
            [
                'contact_field_type' => \App\ContactField::CONTACT_TYPE_SOCIAL_PROFILE,
                'name' => 'LinkedIn',
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now()
            ],
            [
                'contact_field_type' => \App\ContactField::CONTACT_TYPE_SOCIAL_PROFILE,
                'name' => 'Google+',
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now()
            ],
            [
                'contact_field_type' => \App\ContactField::CONTACT_TYPE_SOCIAL_PROFILE,
                'name' => 'Youtube',
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now()
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
        Schema::dropIfExists('default_labels');
    }
}
