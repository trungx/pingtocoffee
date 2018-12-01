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
}
