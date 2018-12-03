<?php

namespace App\Http\Controllers;

use App\Event;
use App\Http\Requests\ReminderRequest;
use App\User;
use App\Reminder;
use App\Helpers\DateHelper;

class RemindersController extends Controller
{
    /**
     * Show add reminder form.
     *
     * @param User $user
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create(User $user)
    {
        return view('contacts.reminder.add', [
            'user' => $user,
            'reminder' => new Reminder(),
        ]);
    }

    /**
     * Store reminder to database.
     *
     * @param ReminderRequest $request
     * @param User $user
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(ReminderRequest $request, User $user)
    {
        $userTimezone = auth()->user()->timezone;

        $reminderData = $request->only(['title', 'description']) + [
            'frequency_type' => 'once',
            'frequency_number' => 1,
            'from_user_id' => auth()->user()->id,
            'to_user_id' => $user->id,
            'next_expected_date' => DateHelper::fromHumanToSystem($request->get('next_expected_date'), $userTimezone)
        ];

        if ($request->has('reminders_frequency')) {
            $reminderData['frequency_type'] = $request->get('frequency_type');
            $reminderData['frequency_number'] = $request->get('frequency_number');
        }

        $reminder = Reminder::create($reminderData);

        // Create event log
        $reminder->createLogForFeed(Event::ADD_ACTION);

        return redirect('/' . $user->username . '?tab=reminders')
            ->with('success', trans('user.reminders_add_success'));
    }

    /**
     * Show edit reminder form.
     *
     * @param User $user
     * @param Reminder $reminder
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(User $user, Reminder $reminder)
    {
        return view('contacts.reminder.edit', [
            'user' => $user,
            'reminder' => $reminder
        ]);
    }

    /**
     * Update reminder to database.
     *
     * @param ReminderRequest $request
     * @param User $user
     * @param Reminder $reminder
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(ReminderRequest $request, User $user, Reminder $reminder)
    {
        $reminderData = $request->only(['title', 'description']) + [
            'frequency_type' => 'once',
            'frequency_number' => 1,
            'next_expected_date' => DateHelper::fromHumanToSystem(
                $request->get('next_expected_date'),
                auth()->user()->timezone
            )
        ];

        if ($request->has('reminders_frequency')) {
            $reminderData['frequency_type'] = $request->get('frequency_type');
            $reminderData['frequency_number'] = $request->get('frequency_number');
        }

        $reminder->update($reminderData);

        return redirect('/' . $user->username . '?tab=reminders')
            ->with('success', __('user.reminders_edit_success'));
    }

    /**
     * Delete reminder.
     *
     * @param User $user
     * @param Reminder $reminder
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(User $user, Reminder $reminder)
    {
        try {
            $reminder->delete();

            // Create event log
            $reminder->createLogForFeed(Event::DELETE_ACTION);

            return redirect('/' . $user->username . '?tab=reminders')
                ->with('success', trans('user.reminders_delete_success'));
        } catch (\Exception $e) {
            return redirect('/' . $user->username . '?tab=reminders')
                ->with('error', trans('user.something_wrong'));
        }
    }
}
