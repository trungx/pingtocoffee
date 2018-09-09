<?php

namespace App\Jobs;

use App\User;
use App\Reminder;
use App\Mail\ReminderEmail;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Mail;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendReminderEmail implements ShouldQueue
{
    use InteractsWithQueue, Queueable, SerializesModels;

    protected $reminder;
    protected $fromUser;
    protected $toUser;

    /**
     * SendReminderEmail constructor.
     *
     * @param Reminder $reminder
     * @param User $fromUser
     * @param User $toUser
     */
    public function __construct(Reminder $reminder, User $fromUser, User $toUser)
    {
        $this->reminder = $reminder;
        $this->fromUser = $fromUser;
        $this->toUser = $toUser;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Mail::to($this->fromUser->email)->send(new ReminderEmail($this->reminder, $this->fromUser, $this->toUser));
    }
}
