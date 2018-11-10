<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Force production URL to use https protocol
if (config('app.env') === 'production') {
    URL::forceScheme('https');
}

Route::get('/', function () {
    if (auth()->check()) {
        return redirect()->route('dashboard.index');
    }
    return redirect()->route('home');
});
Route::get('/home', 'HomeController@index')->name('home');
Route::get('/users/destroy/success', 'UsersController@destroySuccess')->name('users.destroy-success');

Auth::routes(['verify' => true]);

Route::middleware(['auth'])->group(function () {
    // Dashboard
    Route::get('/dashboard', 'DashboardController@index')->name('dashboard.index');
    Route::get('/dashboard/summary/logs', 'DashboardController@getContactLogs');
    Route::get('/dashboard/summary/reminders', 'DashboardController@getNextReminders');

    // Settings
    Route::group(['prefix' => 'settings', 'as' => 'settings'], function () {
        // Account
        Route::get('/', 'SettingsController@show')->name('.show');
        Route::post('/store', 'SettingsController@store')->name('.store');
        Route::post('/upload-avatar', 'SettingsController@uploadAvatar')->name('.upload-avatar');

        // Contact fields
        Route::get('/contactfield', 'ContactFieldsController@index')->name('.contact-field.index');
        Route::get('/contactfield/create', 'ContactFieldsController@create')->name('.contact-field.create');
        Route::post('/contactfield', 'ContactFieldsController@store')->name('.contact-field.store');
        Route::get('/contactfield/{field}/edit', 'ContactFieldsController@edit')->name('.contact-field.edit');
        Route::patch('/contactfield/{field}', 'ContactFieldsController@update')->name('.contact-field.update');
        Route::delete('/contactfield/{field}', 'ContactFieldsController@destroy')->name('.contact-field.destroy');

        // Security
        Route::get('/security', 'SettingsController@security')->name('.security.show');
        Route::put('/security', 'Auth\\ChangePasswordController@update')->name('.security.update');
    });

    // Verification
    Route::post('/email/verify/resend/{user}', 'Auth\VerificationController@resend')->name('resend-verification-email');
    
    // Users
    Route::post('/users/search', 'UsersController@search')->name('users.search');
    Route::post('/users/destroy', 'UsersController@destroy')->name('users.destroy');
    Route::post('/users/reverse', 'UsersController@reverse')->name('users.reverse');

    // Referrals
    Route::get('/referrals', 'UsersController@showReferralsForm')->name('.referrals.showReferralsForm');
    Route::post('/referrals', 'UsersController@sendInvite');

    // Contacts
    Route::get('/contacts', 'ContactController@index')->name('contacts.index');
    Route::get('/contacts/all-received-requests', 'ContactController@allReceivedRequests')->name('contacts.all-received-requests');
    Route::get('/contacts/all-requests-sent', 'ContactController@allRequestsSent')->name('contacts.all-requests-sent');
    Route::get('/contacts/received-requests', 'ContactController@receivedRequests')->name('contacts.received-requests');
    Route::get('/contacts/requests-sent', 'ContactController@requestsSent')->name('contacts.requests-sent');

    // Contacts Requests
    Route::get('/contacts/requests', 'ContactController@requests')->name('contact.requests');

    // Activity log
    Route::get('/activity-log', 'ContactController@getActivityLogData');
    Route::get('/{user}/activity-log', 'ContactController@activityLog');

    // Contact profile
    Route::get('/{user}', 'ContactController@show')->name('contact.show');
    Route::group(['prefix' => 'contact', 'as' => 'contact'], function() {
        // Notes
        Route::post('/{user}/note', 'NoteController@store')->name('.note.store');
        Route::delete('/{user}/note/{note}', 'NoteController@destroy')->name('.note.destroy');

        // Contact logs
        Route::get('/{user}/contact-log', 'ContactLogController@create')->name('.contact-log.create');
        Route::post('/{user}/contact-log', 'ContactLogController@store')->name('.contact-log.store');
        Route::get('/{user}/contact-log/{contactLog}', 'ContactLogController@edit')->name('.contact-log.edit');
        Route::put('/{user}/contact-log/{contactLog}', 'ContactLogController@update')->name('.contact-log.update');
        Route::delete('/{user}/contact-log/{contactLog}', 'ContactLogController@destroy')->name('.contact-log.destroy');

        // Reminders
        Route::get('/{user}/reminder', 'RemindersController@create')->name('.reminder.create');
        Route::post('/{user}/reminder', 'RemindersController@store')->name('.reminder.store');
        Route::get('/{user}/reminder/{reminder}', 'RemindersController@edit')->name('.reminder.edit');
        Route::put('/{user}/reminder/{reminder}', 'RemindersController@update')->name('.reminder.update');
        Route::delete('/{user}/reminder/{reminder}', 'RemindersController@destroy')->name('.reminder.destroy');
    });

    // Relationships
    Route::group(['prefix' => 'relationships', 'as' => 'relationship'], function() {
        Route::post('/{user}/add', 'RelationshipsController@store')->name('.store');
        Route::post('/{user}/cancel', 'RelationshipsController@destroy')->name('.destroy');
        Route::post('/{user}/accept', 'RelationshipsController@update')->name('.update');
        Route::post('/{user}/decline', 'RelationshipsController@destroy')->name('.destroy');
        Route::post('/{user}/block', 'RelationshipsController@block')->name('.block');
    });

    // Tags
    Route::get('/{user}/tags', 'TagsController@list')->name('tags.list');
    Route::post('/{user}/tags', 'TagsController@update')->name('tags.update');
});
