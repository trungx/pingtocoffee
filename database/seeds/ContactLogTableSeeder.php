<?php

use Illuminate\Database\Seeder;

class ContactLogTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $contactLogs = factory(\App\ContactLog::class, config('seeder.contact-log'))->create();

        // Create event log
        foreach ($contactLogs as $contactLog) {
            $contactLog->createLogForFeed(\App\Event::ADD_ACTION);
        }
    }
}
