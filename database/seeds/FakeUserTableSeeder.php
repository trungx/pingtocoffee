<?php

use Illuminate\Database\Seeder;

class FakeUserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $colors = [
            '#fdb660',
            '#93521e',
            '#bd5067',
            '#b3d5fe',
            '#ff9807',
            '#709512',
            '#5f479a',
            '#e5e5cd',
        ];

        // Create a new account
        $account = new \App\Account();
        $account->save();

        $user = \App\User::create([
            'account_id' => $account->id,
            'first_name' => 'Super',
            'last_name' => 'Admin',
            'username' => 'admin',
            'email' => 'admin@pingtocoffee.com',
            'password' => Hash::make('123456'),
            'default_avatar_color' => $colors[mt_rand(0, count($colors) - 1)],
            'referral_code' => \App\User::randomCode(),
        ]);

        // Create log for feed
        $log = \App\DefaultEvent::where('type_of_action', 'sign_up')->first();
        (new \App\Feed)->add($log, $user->id);

        // Create a new account
        $account = new \App\Account();
        $account->save();

        $user = \App\User::create([
            'account_id' => $account->id,
            'first_name' => 'Super',
            'last_name' => 'Tester',
            'username' => 'tester',
            'email' => 'tester@pingtocoffee.com',
            'password' => Hash::make('123456'),
            'default_avatar_color' => $colors[mt_rand(0, count($colors) - 1)],
            'referral_code' => \App\User::randomCode(),
        ]);

        // Create log for feed
        $log = \App\DefaultEvent::where('type_of_action', 'sign_up')->first();
        (new \App\Feed)->add($log, $user->id);
    }
}
