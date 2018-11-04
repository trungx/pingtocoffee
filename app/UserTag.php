<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserTag extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'user_tag';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'from_user_id',
        'to_user_id',
        'tag_id',
    ];

    /**
     * Get tags
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function tag()
    {
        return $this->belongsTo('App\Tag', 'tag_id');
    }
}
