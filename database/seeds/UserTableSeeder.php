<?php

use Illuminate\Database\Seeder;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = factory(\App\User::class, config('seeder.user'))->create();

        // Create log for feed
        $log = \App\DefaultEvent::where('type_of_action', 'sign_up')->first();
        (new \App\Feed)->add($log, $user->first()->id);
    }
}
