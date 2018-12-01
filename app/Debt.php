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
}
