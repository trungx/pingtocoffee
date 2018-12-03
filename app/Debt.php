<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Debt extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    public $fillable = [
        'from_user_id',
        'to_user_id',
        'in_debt',
        'amount',
        'reason',
    ];

    /**
     * Scope of debt owner.
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
     * Scope of debt contact.
     *
     * @param $query
     * @param $userId
     * @return mixed
     */
    public function scopeOfContact($query, $userId)
    {
        return $query->where('to_user_id', $userId);
    }

    /**
     * Log a debt event for news feed.
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
        $event->icon_class = __('dashboard.debts_icon_class');
        $event->type_of_action = $typeOfAction;
        $event->save();

        // Create event entry for feed
        (new Feed)->add($event, $this->from_user_id);
    }
}
