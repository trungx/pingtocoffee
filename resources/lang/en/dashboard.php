<?php

return [
    // Default event body
    'feed_heading' => 'Activity Browser',
    'signed_up_event' => 'Hooray! You signed up and become a member of ' . env('APP_NAME', 'Ping to coffee'),
    'first_reminder_event' => 'You created the first reminder!',
    'add_contact_log_event_body' => 'You added a contact log for <a href="/contact/:userId?tab=contact-logs" class="link-gray-dark b">:fullName</a>',
    'add_reminder_event_body' => 'You set new reminder for <a href="/contact/:userId?tab=reminders" class="link-gray-dark b">:fullName</a>',
    'edit_reminder_event_body' => 'You edit reminder of <a href="/contact/:userId" class="link-gray-dark b">:fullName</a>',
    'add_user_event_body' => 'You and <a href="/contact/:userId" class="link-gray-dark b">:fullName</a> has been friends!',

    // Default event icons
    'signed_up_icon_class' => 'fas fa-trophy',
    'reminders_icon_class' => 'fas fa-bell',
    'users_icon_class' => 'fas fa-user-friends',
    'contact_logs_icon_class' => 'fas fa-history',

    // Button
    'load_more' => 'Load more',
    'loading' => 'Loading...',
];
