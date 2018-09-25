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

    protected $user;

    /**
     * DestroyUser constructor.
     * @param $user
     */
    public function __construct($user)
    {
        $this->user = $user;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        // Delete relationship.
        Relationship::where('user_first_id', $this->user->id)
            ->orWhere('user_second_id', $this->user->id)
            ->delete();

        // Delete contact logs.
        ContactLog::where('from_user_id', $this->user->id)->delete();

        // Delete reminders.
        Reminder::where('from_user_id', $this->user->id)->delete();

        // Delete contact information.
        ContactFieldValue::where('user_id', $this->user->id)->delete();

        // Delete feeds.
        Feed::where('user_id', $this->user->id)->delete();

        // Delete account.
        Account::where('id', $this->user->account_id)->delete();

        // Delete user.
        $this->user->delete();
    }
}
