<?php

return [
    // Default event body
    'feed_heading' => 'Activity Log',
    'signed_up_event' => 'Hooray! You signed up and become a member of ' . config('app.name'),
    'first_reminder_event' => 'You created the first reminder!',
    'add_user_event_body' => 'You and <a href="/:username">:fullName</a> has been friends!',
    'add_note_event_body' => 'You added a note for <a href="/:username?tab=notes">:fullName</a>',
    'delete_note_event_body' => 'You deleted a note of <a href="/:username?tab=notes">:fullName</a>',
    'add_contact_log_event_body' => 'You added a contact log for <a href="/:username?tab=contact-logs">:fullName</a>',
    'add_reminder_event_body' => 'You set new reminder for <a href="/:username?tab=reminders">:fullName</a>',
    'delete_reminder_event_body' => 'You deleted a reminder of <a href="/:username?tab=reminders">:fullName</a>',
    'add_debt_event_body' => 'You added a debt for <a href="/:username?tab=debts">:fullName</a>',
    'delete_debt_event_body' => 'You deleted a debt of <a href="/:username?tab=debts">:fullName</a>',

    // Default event icons
    'signed_up_icon_class' => 'fas fa-trophy',
    'notes_icon_class' => 'fas fa-edit',
    'reminders_icon_class' => 'fas fa-bell',
    'users_icon_class' => 'fas fa-user-friends',
    'contact_logs_icon_class' => 'fas fa-history',
    'debts_icon_class' => 'fas fa-dollar-sign',

    // Button
    'load_more' => 'Load more',
    'loading' => 'Loading...',

    'joined_on' => 'Joined :date',
    'born_on' => 'Born :date',
    'contacts' => 'Contacts',
    'notes' => 'Notes',
    'reminders' => 'Reminders',
];
