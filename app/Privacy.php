<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Privacy extends Model
{
    const PUBLIC_PRIVACY = 'public';
    const FRIENDS_PRIVACY = 'friends';
    const ONLY_ME_PRIVACY = 'only_me';

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'privacy';
}
