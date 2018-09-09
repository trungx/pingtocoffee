<?php

use Illuminate\Database\Seeder;

class ReminderTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $reminders = factory(\App\Reminder::class, config('seeder.reminder'))->create();

        // Create log for feed
        foreach ($reminders as $reminder) {
            $reminder->createLogForFeed(\App\Event::ADD_ACTION);
        }
    }
}
