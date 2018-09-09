<?php

namespace App;

use App\Helpers\DateHelper;
use Illuminate\Database\Eloquent\Model;

class Reminder extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'from_user_id',
        'to_user_id',
        'title',
        'description',
        'frequency_type',
        'frequency_number',
        'last_triggered',
        'next_expected_date',
    ];

    /**
     * Get owner information of reminder.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function owner()
    {
        return $this->belongsTo('App\User', 'from_user_id');
    }

    /**
     * Get contact information of reminder.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function contact()
    {
        return $this->belongsTo('App\User', 'to_user_id');
    }

    /**
     * Get expected date
     *
     * @param $value
     * @return \Carbon\Carbon
     */
    public function getNextExpectedDateAttribute($value)
    {
        return \Carbon\Carbon::parse($value);
    }

    /**
     * Calculate next_expected_date attribute
     *
     * @return $this
     */
    public function calculateNextExpectedDate()
    {
        $date = $this->next_expected_date;

        // Increase time while it past
        while ($date->isPast()) {
            $this->next_expected_date = DateHelper::addTimeAccordingToFrequencyType($date, $this->frequency_type, $this->frequency_number);
        }

        if ($date->isToday()) {
            $this->next_expected_date = DateHelper::addTimeAccordingToFrequencyType($date, $this->frequency_type, $this->frequency_number);
        }

        $this->next_expected_date = $date;

        return $this;
    }

    /**
     * Log a reminder event for news feed.
     *
     * @param $typeOfAction
     */
    public function createLogForFeed($typeOfAction)
    {
        // Insert event log.
        $event = new Event();
        $event->from_user_id = $this->from_user_id;
        $event->to_user_id = $this->to_user_id;
        $event->object_id = $this->id;
        $event->object_type = get_class($this);
        $event->icon_class = __('dashboard.reminders_icon_class');
        $event->type_of_action = $typeOfAction;
        $event->save();

        // Create event entry for feed
        (new Feed)->add($event, $this->from_user_id);
    }

    /**
     * Scope of reminder owner.
     *
     * @param $query
     * @param $userId
     * @return mixed
     */
    public function scopeOfOwner($query, $userId)
    {
        return $query->where('from_user_id', $userId);
    }

    /**
     * Scope of reminder contact.
     *
     * @param $query
     * @param $userId
     * @return mixed
     */
    public function scopeOfContact($query, $userId)
    {
        return $query->where('to_user_id', $userId);
    }
}
