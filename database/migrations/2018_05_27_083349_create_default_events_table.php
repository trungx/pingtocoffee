<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Carbon\Carbon;

class CreateDefaultEventsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('default_events', function (Blueprint $table) {
            $table->increments('id');
            $table->string('body');
            $table->string('icon_class');
            $table->string('type_of_action');
            $table->timestamps();
        });

        DB::table('default_events')->insert([
            [
                'body' => 'signed_up_event',
                'icon_class' => 'signed_up_icon_class',
                'type_of_action' => \App\DefaultEvent::DEFAULT_EVENT_SIGN_UP,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
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
        Schema::dropIfExists('default_events');
    }
}
