<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Feed extends Model
{
    /**
     * Get the account record associated with the invitation.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the information about the object represented by the feed.
     *
     * @return array
     */
    public function getObjectData()
    {
        $type = $this->feedable_type;

        // Instantiating the object
        $correspondingObject = (new $type)->findOrFail($this->feedable_id);

        return $correspondingObject->getInfoForFeed();
    }

    /**
     * Add a new event log to feed
     *
     * @param $resourceToLog
     * @param $userId
     * @return $this
     */
    public function add($resourceToLog, $userId)
    {
        $this->user_id = $userId;
        $this->datetime = now();
        $this->feedable_id = $resourceToLog->id;
        $this->feedable_type = get_class($resourceToLog);
        $this->save();

        return $this;
    }
}
