<?php

namespace App\Http\Controllers;

use App\User;
use App\Relationship;
use Illuminate\Http\Request;
use App\Helpers\DateHelper;

class ContactController extends Controller
{
    /**
     * Retrieve list contacts
     *
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        // Filter contacts by tags.
        $filterTag = auth()->user()->tags()->where('name', $request->tag)->first();

        $tags = auth()->user()->tags()->get();

        $contacts = auth()->user()->contacts($filterTag);

        $contacts->each(function ($contact) {
            $contact->joined_on = $contact->created_at->format('M Y');
        });

        return view('contacts.index', [
            'contacts' => $contacts,
            'tags' => $tags,
        ]);
    }

    /**
     * Show contact information
     *
     * @param Request $request
     * @param User $user
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show(Request $request, User $user)
    {
        $customInformation = collect();
        $notes = collect();
        $reminders = collect();
        $contactLogs = collect();
        $activeTab = $request->get('tab');

        switch ($activeTab) {
            case 'notes':
                $notes = auth()->user()->getNotes($user->id);
                break;
            case 'contact-logs':
                $contactLogs = auth()->user()->getContactLogs($user->id);
                break;
            case 'reminders':
                $reminders = auth()->user()->getReminders($user->id);
                break;
            default:
                $activeTab = 'notes';
                $notes = auth()->user()->getNotes($user->id);
                break;
        }

        $sortedUsers = collect([auth()->user(), $user])->sortBy('id');
        $relationship = Relationship::where([
            'user_first_id' => $sortedUsers->first()->id,
            'user_second_id' => $sortedUsers->last()->id,
        ])->first();

        $relationship = $relationship ?? new Relationship();
        $contactInformation = $user->getContactInformation($relationship->type);

        if (isset($contactInformation['social'])) {
            $customInformation = $contactInformation['social']->groupBy('defaultLabel.name');
        }

        return view('contacts.show', [
            'user' => $user,
            'activeTab' => $activeTab,
            'relationship' => $relationship,
            'notes' => $notes,
            'reminders' => $reminders,
            'contactLogs' => $contactLogs,
            'customInformation' => $customInformation,
            'contactInformation' => $contactInformation,
            'isProfileOwner' => $user->id == auth()->user()->id,
        ]);
    }

    /**
     * Get contact requests.
     *
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function requests(Request $request)
    {
        if ($request->has('outgoing')) {
            $outgoingRequests = true;
        } else {
            $outgoingRequests = false;
        }

        return view('contacts.requests.index', [
            'outgoingRequests' => $outgoingRequests,
        ]);
    }

    /**
     * Retrieve all received requests.
     *
     * @return mixed
     */
    protected function allReceivedRequests()
    {
        $receivedRequests = auth()->user()->receivedRequests();
        $receivedRequests->each(function($item) {
            $item->state = 'none';
        });

        return response()->json([
            'receivedRequests' => $receivedRequests,
        ]);

    }

    /**
     * Retrieve all requests sent.
     *
     * @return mixed
     */
    protected function allRequestsSent()
    {
        $requestsSent = auth()->user()->requestsSent();
        $requestsSent->each(function($item) {
            $item->state = 'requestSent';
        });

        return response()->json([
            'requestsSent' => $requestsSent,
        ]);
    }

    /**
     * Retrieve received requests.
     *
     * @return mixed
     */
    public function receivedRequests()
    {
        $enableSeeAll = false;
        $receivedRequests = auth()->user()->receivedRequests();

        if ($receivedRequests->count() > User::RECEIVED_REQUESTS_LIMIT) {
            $enableSeeAll = true;
            $receivedRequests = $receivedRequests->take(User::RECEIVED_REQUESTS_LIMIT);
        }

        $receivedRequests->each(function($item) {
            $item->state = 'none';
        });

        return response()->json([
            'receivedRequests' => $receivedRequests,
            'enableSeeAll' => $enableSeeAll,
        ]);
    }

    /**
     * Retrieve requests sent.
     *
     * @return mixed
     */
    public function requestsSent()
    {
        $enableSeeAll = false;
        $requestsSent = auth()->user()->requestsSent();

        if ($requestsSent->count() > User::REQUESTS_SENT_LIMIT) {
            $enableSeeAll = true;
            $requestsSent = $requestsSent->take(User::REQUESTS_SENT_LIMIT);
        }

        $requestsSent->each(function($item) {
            $item->state = 'requestSent';
        });

        return response()->json([
            'requestsSent' => $requestsSent,
            'enableSeeAll' => $enableSeeAll,
        ]);
    }

    /**
     * Get activity log records.
     *
     * @return array
     */
    protected function getActivityLogData()
    {
        $activityLogCollect = collect([]);
        $activityLogs = auth()->user()->feeds()->paginate(20);
        $userTimezone = auth()->user()->timezone;

        // determine if we need to display calendar milestone
        $previousLogDate = 0;
        $showCalendar = true;

        foreach ($activityLogs as $activityLog) {
            $logDate = $activityLog->created_at->copy()->format('Y-m-d');
            if ($previousLogDate == $logDate) {
                $showCalendar = false;
            }

            $data = [
                'id' => $activityLog->id,
                'feedable_id' => $activityLog->feedable_id,
                'feedable_type' => $activityLog->feedable_type,
                'object' => $activityLog->getObjectData(),
                'datetime' => \Carbon\Carbon::createFromTimestamp(strtotime($activityLog->datetime))->diffForHumans(),
                'full_datetime' => DateHelper::convertToTimezone($activityLog->datetime, $userTimezone)->format('F d, Y, h:i A'),
                'show_calendar' => $showCalendar,
            ];

            $activityLogCollect->push($data);

            $previousLogDate = $logDate;
            $showCalendar = true;
        }

        return [
            'total' => $activityLogs->total(),
            'per_page' => $activityLogs->perPage(),
            'current_page' => $activityLogs->currentPage(),
            'next_page_url' => $activityLogs->nextPageUrl(),
            'prev_page_url' => $activityLogs->previousPageUrl(),
            'data' => $activityLogCollect,
        ];
    }

    /**
     * Get activity log
     *
     * @param User $user
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function activityLog(User $user)
    {
        // Verify just logged in user can access.
        if (auth()->user()->id != $user->id) {
            return redirect('/' . $user->username);
        }

        $customInformation = collect();
        $sortedUsers = collect([auth()->user(), $user])->sortBy('id');
        $relationship = Relationship::where([
            'user_first_id' => $sortedUsers->first()->id,
            'user_second_id' => $sortedUsers->last()->id,
        ])->first();

        $relationship = $relationship ?? new Relationship();
        $contactInformation = $user->getContactInformation($relationship->type);

        if (isset($contactInformation['social'])) {
            $customInformation = $contactInformation['social']->groupBy('defaultLabel.name');
        }

        return view('contacts.activity-log', [
            'user' => $user,
            'relationship' => $relationship,
            'customInformation' => $customInformation,
            'contactInformation' => $contactInformation,
        ]);
    }
}
