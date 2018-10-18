<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Storage;
use App\Traits\Searchable;
use App\Helpers\DateHelper;
use App\Helpers\ImageHelper;
use Carbon\Carbon;
use Illuminate\Contracts\Auth\MustVerifyEmail;

class User extends Authenticatable implements MustVerifyEmail
{
    use Notifiable;
    use Searchable;

    /**
     * This is limit result for requests sent
     */
    const REQUESTS_SENT_LIMIT = 10;

    /**
     * This is limit result for received requests
     */
    const RECEIVED_REQUESTS_LIMIT = 10;


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'account_id',
        'first_name',
        'last_name',
        'description',
        'username',
        'email',
        'password',
        'birthday',
        'gender',
        'timezone',
        'locale',
        'has_avatar',
        'avatar_file_name',
        'referral_code',
        'destroy_date',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * Searchable fields
     *
     * @var array
     */
    protected $searchableColumns = [
        'first_name',
        'last_name',
        [
            'first_name',
            'last_name'
        ]
    ];

    /**
     * Get the Contact Field Value records associated with the user.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function contactFieldValues()
    {
        return $this->hasMany('App\ContactFieldValue');
    }

    /**
     * Get the account associated with the user
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function account()
    {
        return $this->belongsTo('App\Account');
    }

    /**
     * Get reminder records
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function reminders()
    {
        return $this->hasMany('App\Reminder', 'from_user_id')->orderBy('next_expected_date', 'asc');
    }

    /**
     * Get the feed records
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function feeds()
    {
        return $this->hasMany('App\Feed')->orderBy('id', 'desc');
    }

    /**
     * Get contact logs records
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function contactLogs()
    {
        return $this->hasMany('App\ContactLog', 'from_user_id')->orderBy('contact_time', 'desc');
    }

    /**
     * Get contacts of user.
     *
     * @return mixed
     */
    public function contacts()
    {
        return User::whereIn('id', Relationship::contactIds($this->id))->get();
    }

    /**
     * Get list received contact requests.
     *
     * @return mixed
     */
    public function receivedRequests()
    {
        $receivedRequests = self::whereIn('id', Relationship::receivedRequestIds($this->id))->get();

        $receivedRequests->map(function ($user) {
            $user->completeName = $user->getCompleteName();

            if ($user->has_avatar) {
                $user->avatar = $user->getAvatarUrl(ImageHelper::SMALL_SIZE);
            } else {
                $user->initials = $user->getInitials();
            }
        });

        return $receivedRequests;
    }

    /**
     * Get list requests contact sent.
     *
     * @return mixed
     */
    public function requestsSent()
    {
        $requestsSent = self::whereIn('id', Relationship::requestSentIds($this->id))->get();

        $requestsSent->map(function ($user) {
            $user->completeName = $user->getCompleteName();

            if ($user->has_avatar) {
                $user->avatar = $user->getAvatarUrl(ImageHelper::SMALL_SIZE);
            } else {
                $user->initials = $user->getInitials();
            }
        });

        return $requestsSent;
    }

    /**
     * Get avatar url
     *
     * @param int $size
     * @return mixed
     */
    public function getAvatarUrl($size = 300)
    {
        $originalAvatarUrl = Storage::disk('local')->url($this->avatar_file_name);
        $avatarFilename = pathinfo($originalAvatarUrl, PATHINFO_FILENAME);
        $avatarExtension = pathinfo($originalAvatarUrl, PATHINFO_EXTENSION);
        $resizedAvatar = 'avatars/'.$avatarFilename . '_' . $size . '.' . $avatarExtension;

        return Storage::disk('local')->url($resizedAvatar);
    }

    /**
     * Get complete name
     *
     * @return string
     */
    public function getCompleteName()
    {
        return implode(" ", [$this->first_name, $this->last_name]);
    }

    /**
     * Get initials name
     *
     * @return string
     */
    public function getInitialsAttribute()
    {
        preg_match_all('/(?<=\s|^)[a-zA-Z0-9]/i', $this->getCompleteName(), $initials);

        return implode('', $initials[0]);
    }

    /**
     * Get the initials of the contact, used for avatars.
     *
     * @return string
     */
    public function getInitials()
    {
        return $this->initials;
    }

    /**
     * Get the indexable data array for the model.
     *
     * @return array
     */
    public function toSearchableArray()
    {
        return $this->only($this->searchableColumns);
    }

    /**
     * Set the default avatar color for this object.
     *
     * @param string|null $color
     * @return void
     */
    public function setAvatarColor($color = null)
    {
        $colors = [
            '#fdb660',
            '#93521e',
            '#bd5067',
            '#b3d5fe',
            '#ff9807',
            '#709512',
            '#5f479a',
            '#e5e5cd',
        ];

        $this->default_avatar_color = $color ?? $colors[mt_rand(0, count($colors) - 1)];

        $this->save();
    }

    /**
     * Get reminders of contact
     *
     * @param $contactId
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getReminders($contactId)
    {
        $reminders = $this->reminders()->ofContact($contactId)->get();

        $reminders->map(function($reminder) {
            switch ($reminder->frequency_number) {
                case 1:
                    if ($reminder->frequency_type == 'once') {
                        $reminder->frequency_type = __('user.once_frequency_str');
                    } else {
                        $reminder->frequency_type = __('user.one_' . $reminder->frequency_type . '_frequency_str');
                    }
                    break;
                default:
                    $reminder->frequency_type = __('user.many_' . $reminder->frequency_type . '_frequency_str', [
                        'frequency' => $reminder->frequency_number
                    ]);

                    break;
            }

            $reminder->next_expected_date = DateHelper::convertToTimezone($reminder->next_expected_date, $this->timezone);
        });

        return $reminders;
    }

    /**
     * Get contact logs of contact
     *
     * @param $contactId
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getContactLogs($contactId)
    {
        $contactLogs = $this->contactLogs()->ofContact($contactId)->get();
        $contactLogs->map(function($item) {
            $item->contact_time = DateHelper::convertToTimezone($item->contact_time, $this->timezone);
        });
        return $contactLogs;
    }

    /**
     * Log a reminder event for newsfeed.
     *
     * @param $fromUserId
     * @param $toUserId
     * @param $typeOfAction
     */
    public function createLogForFeed($fromUserId, $toUserId, $typeOfAction)
    {
        // Insert event for accepting user.
        $event = new Event();
        $event->from_user_id = $fromUserId;
        $event->to_user_id = $toUserId;
        $event->object_id = $this->id;
        $event->object_type = get_class($this);
        $event->icon_class = __('dashboard.users_icon_class');
        $event->type_of_action = $typeOfAction;
        $event->save();

        // Create event entry for accept user's feed
        (new Feed)->add($event, $fromUserId);

        // Insert event for be accepted user also.
        $event = new Event();
        $event->from_user_id = $toUserId;
        $event->to_user_id = $fromUserId;
        $event->object_id = $this->id;
        $event->object_type = get_class($this);
        $event->icon_class = __('dashboard.users_icon_class');
        $event->type_of_action = $typeOfAction;
        $event->save();

        // Create event entry for be accepted user's feed
        (new Feed)->add($event, $toUserId);
    }

    /**
     * Get contact information of contact.
     *
     * @param $typeOfRelationship
     * @return mixed
     */
    public function getContactInformation($typeOfRelationship)
    {
        if ($this->isContactOwnerOf(auth()->user()->id)) {
            $typeOfRelationship = Relationship::OWNER;
        }

        switch ($typeOfRelationship) {
            case Relationship::FRIENDS_TYPE:
                $contactFieldValues = $this->contactFieldValues()
                    ->friends()
                    ->with(['contactField', 'defaultLabel'])
                    ->get();
                break;
            case Relationship::OWNER:
                $contactFieldValues = $this->contactFieldValues()
                    ->onlyMe()
                    ->with(['contactField', 'defaultLabel'])
                    ->get();
                break;
            default:
                $contactFieldValues = $this->contactFieldValues()
                    ->public()
                    ->with(['contactField', 'defaultLabel'])
                    ->get();
                break;
        }
        return $contactFieldValues->groupBy('contactField.type');
    }

    /**
     * Check contact is own.
     *
     * @param $contactId
     * @return bool
     */
    public function isContactOwnerOf($contactId)
    {
        return $this->id == $contactId;
    }

    /**
     * Random the unique code.
     *
     * @param $limit
     * @return bool|string
     */
    public static function randomCode($limit = 10)
    {
        return substr(base_convert(sha1(uniqid(mt_rand())), 16, 36), 0, $limit);
    }

    /**
     * Scope get non-blocking users.
     *
     * @param $query
     * @return mixed
     */
    public function scopeNonBlockingUsers($query)
    {
        return $query->whereNotIn('id', Relationship::blockedIds($this->id));
    }

    /**
     * Generate unique username.
     *
     * @param string $email
     * @param int $randNo
     * @return string
     */
    public static function generateUniqueUsername($email, $randNo = 200) {
        while (true) {
            $emailPart = strstr($email, '@', true);
            $randNumberPart = ($randNo) ? rand(0, $randNo) : "";
            $username = $emailPart . $randNumberPart;
            
            $usernameAlreadyBeenTaken = User::hasUsernameAlreadyBeenTaken($username); //check username in database
            if (!$usernameAlreadyBeenTaken) {
                return $username;
            }
        }
    }

    /**
     * Validate username already has been taken.
     *
     * @param $userName
     * @return mixed
     */
    public static function hasUsernameAlreadyBeenTaken($userName)
    {
        return User::where('username', $userName)->exists();
    }

    /**
     * Check if today is user birthday.
     *
     * @return bool
     */
    public function isBirthdayToday()
    {
        if (empty($this->birthday)) {
            return false;
        }
        $birthday = Carbon::createFromFormat('Y-m-d', $this->birthday)->format('m-d');
        $today = Carbon::now()->format('m-d');
        return $birthday == $today;
    }
}
