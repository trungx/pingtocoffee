<?php

namespace App\Jobs;

use App\ContactFieldValue;
use App\ContactLog;
use App\Feed;
use App\Relationship;
use App\Reminder;
use App\Account;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class DestroyUser implements ShouldQueue
{
    use InteractsWithQueue, Queueable, SerializesModels;

    protected $users;

    /**
     * DestroyUser constructor.
     * @param $users
     */
    public function __construct($users)
    {
        $this->users = $users;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        foreach ($this->users as $user) {
            // Delete relationship.
            Relationship::where('user_first_id', $user->id)
                ->orWhere('user_second_id', $user->id)
                ->delete();

            // Delete contact logs.
            ContactLog::where('from_user_id', $user->id)->delete();

            // Delete reminders.
            Reminder::where('from_user_id', $user->id)->delete();

            // Delete contact information.
            ContactFieldValue::where('user_id', $user->id)->delete();

            // Delete feeds.
            Feed::where('user_id', $user->id)->delete();

            // Delete account.
            Account::where('id', $user->account_id)->delete();

            // Delete user.
            $user->delete();
        }
    }
}
