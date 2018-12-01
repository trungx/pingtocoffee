<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Relationship extends Model
{
    // Types of relationship
    // Shouldn't change.
    const PENDING_FIRST_SECOND_TYPE = 'pending_first_second';
    const PENDING_SECOND_FIRST_TYPE = 'pending_second_first';
    const FRIENDS_TYPE = 'friends';
    const BLOCK_TYPE = 'block';
    const NONE = 'none';
    const OWNER = 'owner';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_first_id',
        'user_second_id',
        'type'
    ];

    /**
     * Get contact ids of specific user.
     *
     * @param $userId
     * @return array
     */
    public static function contactIds($userId)
    {
        $contactIds = array();
        $relationships = Relationship::friends()->where(function($query) use ($userId) {
            $query->where('user_first_id', $userId)->orWhere('user_second_id', $userId);
        })->get();

        foreach ($relationships as $relationship) {
            if ($relationship->user_first_id == $userId) {
                $contactIds[] = $relationship->user_second_id;
            } else {
                $contactIds[] = $relationship->user_first_id;
            }
        }
        return $contactIds;
    }

    /**
     * Get blocked user ids of specific user.
     *
     * @param $userId
     * @return array
     */
    public static function blockedIds($userId)
    {
        $blockedIds = array();
        $relationships = Relationship::blocked()->where(function($query) use ($userId) {
            $query->where('user_first_id', $userId)->orWhere('user_second_id', $userId);
        })->get();

        foreach ($relationships as $relationship) {
            if ($relationship->user_first_id == $userId) {
                $blockedIds[] = $relationship->user_second_id;
            } else {
                $blockedIds[] = $relationship->user_first_id;
            }
        }
        return $blockedIds;
    }

    /**
     * Get list ids request are received
     *
     * @param $userId
     * @return array
     */
    public static function receivedRequestIds($userId)
    {
        $contactIds = array();
        $relationships = self::where(function($query) use ($userId) {
            $query->where('user_first_id', $userId)->pendingSecondFirst();
        })->orWhere(function($query2) use ($userId) {
            $query2->where('user_second_id', $userId)->pendingFirstSecond();
        })->get();

        foreach($relationships as $relationship) {
            if ($relationship->user_first_id == $userId) {
                $contactIds[] = $relationship->user_second_id;
            } else {
                $contactIds[] = $relationship->user_first_id;
            }
        }

        return $contactIds;
    }

    /**
     * Get list ids requests sent.
     *
     * @param $userId
     * @return array
     */
    public static function requestSentIds($userId)
    {
        $contactIds = array();
        $relationships = self::where(function($query) use ($userId) {
            $query->where('user_first_id', $userId)->pendingFirstSecond();
        })->orWhere(function($query2) use ($userId) {
            $query2->where('user_second_id', $userId)->pendingSecondFirst();
        })->get();

        foreach ($relationships as $relationship) {
            if ($relationship->user_first_id == $userId) {
                $contactIds[] = $relationship->user_second_id;
            } else {
                $contactIds[] = $relationship->user_first_id;
            }
        }

        return $contactIds;
    }

    /**
     * Pending first - second relationship.
     *
     * @param $query
     * @return mixed
     */
    public function scopePendingFirstSecond($query)
    {
        return $query->where('type', self::PENDING_FIRST_SECOND_TYPE);
    }

    /**
     * Pending second - first relationship.
     *
     * @param $query
     * @return mixed
     */
    public function scopePendingSecondFirst($query)
    {
        return $query->where('type', self::PENDING_SECOND_FIRST_TYPE);
    }

    /**
     * Scope relationship have type is friends.
     *
     * @param $query
     * @return mixed
     */
    public function scopeFriends($query)
    {
        return $query->where('type', self::FRIENDS_TYPE);
    }

    /**
     * Scope relationship have type is blocked.
     *
     * @param $query
     * @return mixed
     */
    public function scopeBlocked($query)
    {
        return $query->where('type', self::BLOCK_TYPE);
    }

    /**
     * Get relationship type.
     *
     * @param $value
     * @return string
     */
    public function getTypeAttribute($value)
    {
        return $value ?? self::NONE;
    }
}
