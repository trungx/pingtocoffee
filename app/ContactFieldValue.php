<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ContactFieldValue extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'contact_field_id',
        'label_id',
        'privacy_id',
        'value',
    ];

    /**
     * Get the User record associated with the Contact Field Value
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo('App\User');
    }

    /**
     * Get the Contact Field record associated with the Contact Field Value
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function contactField()
    {
        return $this->belongsTo('App\ContactField');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function defaultLabel()
    {
        return $this->belongsTo('App\DefaultLabel', 'label_id', 'id');
    }

    /**
     * Get privacy record associated with the Contact Field Value
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function privacy()
    {
        return $this->belongsTo('App\Privacy');
    }

    /**
     * Get contact information for public privacy
     *
     * @param $query
     * @return mixed
     */
    public function scopePublic($query)
    {
        return $query->whereHas('privacy', function ($query) {
            $query->where('code', Privacy::PUBLIC_PRIVACY);
        });
    }

    /**
     * Get contact information for friend privacy
     *
     * @param $query
     * @return mixed
     */
    public function scopeFriends($query)
    {
        return $query->whereHas('privacy', function ($query) {
            $query->where('code', Privacy::PUBLIC_PRIVACY)
                ->orWhere('code', Privacy::FRIENDS_PRIVACY);
        });
    }

    /**
     * Get contact information for only me privacy
     *
     * @param $query
     * @return mixed
     */
    public function scopeOnlyMe($query)
    {
        return $query->whereHas('privacy', function ($query) {
            $query->where('code', Privacy::PUBLIC_PRIVACY)
                ->orWhere('code', Privacy::FRIENDS_PRIVACY)
                ->orWhere('code', Privacy::ONLY_ME_PRIVACY);
        });
    }
}
