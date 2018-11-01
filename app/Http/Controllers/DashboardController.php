<?php

namespace App\Http\Controllers;

use App\Helpers\DateHelper;
use Carbon\Carbon;

class DashboardController extends Controller
{
    /**
     * Get index dashboard.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $user = auth()->user();
        $user->joined_on = $user->created_at->format('M Y');

        if ($user->birthday) {
            $user->born_on = Carbon::createFromFormat('Y-m-d', $user->birthday)->format('F d, Y');
        }

        // Count contacts.
        $contactsCounted = $user->contacts()->count();

        // Count notes.
        $notesCounted = $user->notes()->count();

        // Count reminders.
        $remindersCounted = $user->reminders()->count();

        return view('dashboard.index', [
            'user' => $user,
            'contactsCounted' => $contactsCounted,
            'notesCounted' => $notesCounted,
            'remindersCounted' => $remindersCounted,
        ]);
    }

    /**
     * Get contact logs for summary.
     *
     * @return \Illuminate\Support\Collection
     */
    public function getContactLogs()
    {
        $contactLogCollect = collect([]);
        $userTimezone = auth()->user()->timezone;
        $contactLogs = auth()->user()->contactLogs()
            ->with(['contact', 'contactType'])
            ->limit(15)
            ->get();

        foreach ($contactLogs as $contactLog) {
            $data = [
                'id' => $contactLog->id,
                'log_icon_class' => config('icons.' . $contactLog->contactType->icon),
                'contact_id' => $contactLog->contact->id,
                'contact_username' => $contactLog->contact->username,
                'contact_name' => $contactLog->contact->getCompleteName(),
                'contact_time' => DateHelper::convertToTimezone($contactLog->contact_time, $userTimezone)->format('M d, h:i A'),
                'full_contact_time' => DateHelper::convertToTimezone($contactLog->contact_time, $userTimezone)->format('F d, Y, h:i A'),
            ];
            $contactLogCollect->push($data);
        }

        return $contactLogCollect;
    }

    /**
     * Get next reminders for summary.
     *
     * @return mixed
     */
    public function getNextReminders()
    {
        $reminderCollect = collect([]);
        $reminders = auth()->user()->reminders()->limit(10)->get();
        $userTimezone = auth()->user()->timezone;

        // determine if we need to display calendar milestone
        $previousRemindDate = 0;
        $showCalendar = true;

        foreach ($reminders as $reminder) {
            $remindDate = DateHelper::convertToTimezone($reminder->next_expected_date, $userTimezone)
                ->format('Y-m-d');
            if ($previousRemindDate == $remindDate) {
                $showCalendar = false;
            }

            $data = [
                'id' => $reminder->id,
                'title' => $reminder->title,
                'next_expected_date' => DateHelper::convertToTimezone($reminder->next_expected_date, $userTimezone)->format('h:i A'),
                'full_next_expected_date' => DateHelper::convertToTimezone($reminder->next_expected_date, $userTimezone)->format('F d, Y, h:i A'),
                'contact_id' => $reminder->contact->id,
                'contact_username' => $reminder->contact->username,
                'contact_name' => $reminder->contact->getCompleteName(),
                'show_calendar' => $showCalendar,
            ];

            if ($showCalendar) {
                $data['calendar'] = DateHelper::convertToTimezone($reminder->next_expected_date, $userTimezone)
                    ->format('d M');
            }

            $reminderCollect->push($data);

            $previousRemindDate = $remindDate;
            $showCalendar = true;
        }
        return $reminderCollect;
    }
}
