<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateContactFieldsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contact_fields', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('type');
            $table->string('protocol')->nullable();
            $table->timestamps();
        });

        // Insert default value
        DB::table('contact_fields')->insert([
            [
                'name' => 'Phone',
                'type' => \App\ContactField::CONTACT_TYPE_PHONE,
                'protocol' => 'tel:',
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now(),
            ],
            [
                'name' => 'Address',
                'type' => \App\ContactField::CONTACT_TYPE_ADDRESS,
                'protocol' => null,
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now(),
            ],
            [
                'name' => 'Email',
                'type' => \App\ContactField::CONTACT_TYPE_EMAIL,
                'protocol' => 'mailto:',
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now(),
            ],
            [
                'name' => 'Social Profile',
                'type' => \App\ContactField::CONTACT_TYPE_SOCIAL_PROFILE,
                'protocol' => null,
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now(),
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
        Schema::dropIfExists('contact_fields');
    }
}
