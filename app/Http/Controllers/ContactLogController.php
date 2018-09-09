<?php

namespace App\Http\Controllers;

use App\Http\Requests\ContactLogRequest;
use App\User;
use App\Event;
use App\ContactLog;
use App\ContactType;
use App\Helpers\DateHelper;

class ContactLogController extends Controller
{
    /**
     * Show contact log's create form.
     *
     * @param User $user
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create(User $user)
    {
        $contactTypes = ContactType::all();
        return view('contacts.log.add', [
            'user' => $user,
            'contactTypes' => $contactTypes,
            'contactLog' => new ContactLog(),
        ]);
    }

    /**
     * Store a contact log.
     *
     * @param ContactLogRequest $request
     * @param User $user
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(ContactLogRequest $request, User $user)
    {
        $data = $request->only(['contact_type', 'notes']) + [
            'contact_time' => DateHelper::fromHumanToSystem($request->get('contact_time'), auth()->user()->timezone),
            'to_user_id' => $user->id
        ];

        $contactLog = auth()->user()->contactLogs()->create($data);

        // Create event log
        $contactLog->createLogForFeed(Event::ADD_ACTION);

        return redirect('/contact/' . $user->id . '?tab=contact-logs');
    }

    /**
     * Show contact log's edit form.
     *
     * @param User $user
     * @param ContactLog $contactLog
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(User $user, ContactLog $contactLog)
    {
        $contactTypes = ContactType::all();
        return view('contacts.log.edit', [
            'contactLog' => $contactLog,
            'contactTypes' => $contactTypes,
            'user' => $user,
        ]);
    }

    /**
     * Update a contact log.
     *
     * @param ContactLogRequest $request
     * @param User $user
     * @param ContactLog $contactLog
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(ContactLogRequest $request, User $user, ContactLog $contactLog)
    {
        $data = $request->only(['contact_type', 'notes']) + [
            'contact_time' => DateHelper::fromHumanToSystem($request->get('contact_time'), auth()->user()->timezone),
        ];
        $contactLog->update($data);
        return redirect('/contact/' . $user->id . '?tab=contact-logs');
    }

    /**
     * Delete a contact log.
     *
     * @param User $user
     * @param ContactLog $contactLog
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     * @throws \Exception
     */
    public function destroy(User $user, ContactLog $contactLog)
    {
        $contactLog->delete();
        return redirect('/contact/' . $user->id . '?tab=contact-logs');
    }
}
