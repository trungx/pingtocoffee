<?php

namespace App\Jobs;

use App\Reminder;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class SetNextReminderDate implements ShouldQueue
{
    use InteractsWithQueue, Queueable, SerializesModels;

    protected $reminder;

    /**
     * SetNextReminderDate constructor.
     *
     * @param Reminder $reminder
     */
    public function __construct(Reminder $reminder)
    {
        $this->reminder = $reminder;
    }

    /**
     * Execute the job.
     *
     * @throws \Exception
     */
    public function handle()
    {
        switch ($this->reminder->frequency_type) {
            case 'once':
                $this->reminder->delete();
                break;
            default:
                $this->reminder->last_triggered = $this->reminder->next_expected_date;
                $this->reminder->calculateNextExpectedDate();
                $this->reminder->save();
                break;
        }
    }
}
