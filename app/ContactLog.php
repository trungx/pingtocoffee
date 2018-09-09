<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ContactLog extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    public $fillable = [
        'from_user_id',
        'to_user_id',
        'contact_type',
        'contact_time',
        'notes',
    ];

    /**
     * Get contact time value.
     * 
     * @param $value
     * @return \Carbon\Carbon
     */
    public function getContactTimeAttribute($value)
    {
        return \Carbon\Carbon::parse($value);
    }

    /**
     * Get contact type information of contact log
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function contactType()
    {
        return $this->belongsTo('App\ContactType', 'contact_type');
    }

    /**
     * Get the user associated with the contact log.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function owner()
    {
        return $this->belongsTo('App\User', 'from_user_id');
    }

    /**
     * Get the user associated with the contact log.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function contact()
    {
        return $this->belongsTo('App\User', 'to_user_id');
    }

    /**
     * Log a contact log event for news feed.
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
        $event->icon_class = __('dashboard.contact_logs_icon_class');
        $event->type_of_action = $typeOfAction;
        $event->save();

        // Create event entry for feed
        (new Feed)->add($event, $this->from_user_id);
    }

    /**
     * Scope of contact log owner.
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
     * Scope of contact log contact.
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
