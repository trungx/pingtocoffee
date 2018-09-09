<?php

namespace App\Http\Controllers;

use App\User;
use App\Relationship;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    /**
     * Retrieve list contacts
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return view('contacts.index', [
            'contacts' => auth()->user()->contacts(),
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
        $reminders = collect();
        $contactLogs = collect();
        $activeTab = $request->get('tab');

        switch ($activeTab) {
            case 'contact-logs':
                $contactLogs = auth()->user()->getContactLogs($user->id);
                break;
            case 'reminders':
                $reminders = auth()->user()->getReminders($user->id);
                break;
            default:
                $activeTab = 'contact-logs';
                $contactLogs = auth()->user()->getContactLogs($user->id);
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
            'reminders' => $reminders,
            'contactLogs' => $contactLogs,
            'customInformation' => $customInformation,
            'contactInformation' => $contactInformation,
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
            $contacts = $this->requestsSent();
        } else {
            $outgoingRequests = false;
            $contacts = $this->receivedRequests();
        }

        return view('contacts.requests.index', [
            'outgoingRequests' => $outgoingRequests,
            'contacts' => $contacts,
        ]);
    }

    /**
     * Retrieve received requests.
     *
     * @return mixed
     */
    protected function receivedRequests()
    {
        return auth()->user()->receivedRequests();
    }

    /**
     * Retrieve requests sent.
     *
     * @return mixed
     */
    protected function requestsSent()
    {
        return auth()->user()->requestsSent();
    }
}
