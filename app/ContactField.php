<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ContactField extends Model
{
    // Don't change these constants.
    const CONTACT_TYPE_PHONE = 'phone';
    const CONTACT_TYPE_EMAIL = 'email';
    const CONTACT_TYPE_ADDRESS = 'address';
    const CONTACT_TYPE_SOCIAL_PROFILE = 'social';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'type',
        'protocol',
    ];

    /**
     * Get Contact Field Value records associated with the Contact
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function contactFieldValues()
    {
        return $this->hasMany('App\ContactFieldValue');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function defaultLabels()
    {
        return $this->hasMany('App\DefaultLabel', 'contact_field_type', 'type');
    }

    /**
     * Scope phone of contact field.
     *
     * @param $query
     * @return mixed
     */
    public function scopePhone($query)
    {
        return $query->where('type', self::CONTACT_TYPE_PHONE);
    }

    /**
     * Scope email of contact field.
     *
     * @param $query
     * @return mixed
     */
    public function scopeEmail($query)
    {
        return $query->where('type', self::CONTACT_TYPE_EMAIL);
    }

    /**
     * Scope address of contact field.
     *
     * @param $query
     * @return mixed
     */
    public function scopeAddress($query)
    {
        return $query->where('type', self::CONTACT_TYPE_ADDRESS);
    }

    /**
     * Scope social of contact field.
     *
     * @param $query
     * @return mixed
     */
    public function scopeSocial($query)
    {
        return $query->where('type', self::CONTACT_TYPE_SOCIAL_PROFILE);
    }
}
