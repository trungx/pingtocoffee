<?php

namespace App\Http\Controllers;

use App\Helpers\DateHelper;

class DashboardController extends Controller
{
    /**
     * Get index dashboard.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return view('dashboard.index');
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
                'contact_time' => DateHelper::convertToTimezone($contactLog->contact_time, $userTimezone)->format('h:i A'),
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

        foreach ($reminders as $reminder) {
            $data = [
                'id' => $reminder->id,
                'title' => $reminder->title,
                'next_expected_date' => DateHelper::convertToTimezone($reminder->next_expected_date, $userTimezone)->format('h:i A'),
                'full_next_expected_date' => DateHelper::convertToTimezone($reminder->next_expected_date, $userTimezone)->format('F d, Y, h:i A'),
                'contact_id' => $reminder->contact->id,
                'contact_username' => $reminder->contact->username,
                'contact_name' => $reminder->contact->getCompleteName(),
            ];
            $reminderCollect->push($data);
        }
        return $reminderCollect;
    }

    /**
     * Get newsfeed records.
     *
     * @return array
     */
    public function getFeeds()
    {
        $feedCollect = collect([]);
        $feeds = auth()->user()->feeds()->paginate(20);
        $userTimezone = auth()->user()->timezone;

        foreach ($feeds as $feed) {
            $data = [
                'id' => $feed->id,
                'feedable_id' => $feed->feedable_id,
                'feedable_type' => $feed->feedable_type,
                'object' => $feed->getObjectData(),
                'datetime' => \Carbon\Carbon::createFromTimestamp(strtotime($feed->datetime))->diffForHumans(),
                'full_datetime' => DateHelper::convertToTimezone($feed->datetime, $userTimezone)->format('F d, Y, h:i A'),
            ];

            $feedCollect->push($data);
        }

        return [
            'total' => $feeds->total(),
            'per_page' => $feeds->perPage(),
            'current_page' => $feeds->currentPage(),
            'next_page_url' => $feeds->nextPageUrl(),
            'prev_page_url' => $feeds->previousPageUrl(),
            'data' => $feedCollect,
        ];
    }
}
