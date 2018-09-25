<?php

namespace App\Console\Commands;

use App\User;
use Carbon\Carbon;
use Illuminate\Console\Command;
use App\Jobs\DestroyUser;

class DestroyUsers extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ping:destroy-users';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Destroy users follow schedule';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        // Get all users need to be deleted today.
        $users = User::where('destroy_date', Carbon::now()->format('Y-m-d'))->delete();

        foreach ($users as $user) {
            dispatch(new DestroyUser($user));
        }
    }
}
