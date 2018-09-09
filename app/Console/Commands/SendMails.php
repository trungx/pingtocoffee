<?php

namespace App\Console\Commands;

use App\User;
use App\Reminder;
use Carbon\Carbon;
use Illuminate\Console\Command;
use App\Jobs\SendReminderEmail;
use App\Jobs\SetNextReminderDate;

class SendMails extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ping:sendmails';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send mail about reminders';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $reminders = Reminder::where('next_expected_date', '<=', Carbon::now(env('APP_DEFAULT_TIMEZONE')))
            ->orderBy('next_expected_date', 'asc')->get();

        foreach ($reminders as $reminder) {
            $fromUser = User::find($reminder->from_user_id);
            $toUser = User::find($reminder->to_user_id);

            if ($fromUser && $toUser) {
                // Execute send reminder's mail.
                dispatch(new SendReminderEmail($reminder, $fromUser, $toUser));

                // Set next time reminder will be sent.
                dispatch(new SetNextReminderDate($reminder));
            }
        }
    }
}
