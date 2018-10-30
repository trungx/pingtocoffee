<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DefaultEvent extends Model
{
    // Don't change these constants.
    const DEFAULT_EVENT_SIGN_UP = 'sign_up';
    const DEFAULT_EVENT_SET_FIRST_REMINDER = 'set_first_reminder';

    /**
     * Get information for display feed log
     *
     * @return array
     */
    public function getInfoForFeed()
    {
        return [
            'body' => __('dashboard.' . $this->body),
            'icon_class' => __('dashboard.' . $this->icon_class),
            'calendar' => $this->created_at
                ->copy()
                ->setTimezone(auth()->user()->timezone)
                ->format('M d'),
        ];
    }
}
