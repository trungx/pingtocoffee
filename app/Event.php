<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    /**
     * Add event type
     */
    const ADD_ACTION = 'add';

    /**
     * Edit event type
     */
    const EDIT_ACTION = 'edit';

    /**
     * Delete event type
     */
    const DELETE_ACTION = 'delete';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    public $fillable = [
        'from_user_id',
        'to_user_id',
        'object_id',
        'object_type',
        'icon_class',
        'type_of_action',
    ];

    /**
     * Get information for display feed log
     *
     * @return array
     */
    public function getInfoForFeed()
    {
        $objectTypeName = snake_case(class_basename($this->object_type));
        $body = __('dashboard.' . $this->type_of_action. '_' . $objectTypeName . '_event_body', [
            'username' => $this->contact->username,
            'fullName' => $this->contact->getCompleteName(),
        ]);

        return [
            'user' => $this->contact,
            'object_id' => $this->object_id,
            'object_type' => $this->object_type,
            'icon_class' => $this->icon_class,
            'type_of_action' => $this->type_of_action,
            'body' => $body,
        ];
    }

    /**
     * Get the user associated with the event.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function owner()
    {
        return $this->belongsTo('App\User', 'from_user_id');
    }

    /**
     * Get the user associated with the event.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function contact()
    {
        return $this->belongsTo('App\User', 'to_user_id');
    }
}
