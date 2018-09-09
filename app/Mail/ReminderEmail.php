<?php

namespace App\Mail;

use App\User;
use App\Reminder;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ReminderEmail extends Mailable
{
    use Queueable, SerializesModels;

    protected $reminder;
    protected $fromUser;
    protected $toUser;

    /**
     * ReminderEmail constructor.
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
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        \App::setLocale($this->fromUser->locale);

        return $this->markdown('emails.contacts.reminder')
            ->subject('You have a reminder today!')
            ->with([
                'reminder' => $this->reminder,
                'fromUser' => $this->fromUser,
                'toUser' => $this->toUser
            ]);
    }
}
