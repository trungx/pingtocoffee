<?php

namespace Tests\Feature;

use App\Reminder;
use App\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\FeatureTestcase;

class ReminderTest extends FeatureTestcase
{
    use RefreshDatabase;

    public function testCanAddSuccess()
    {
        $user = $this->logIn();

        $friend = factory(User::class)->create();

        $this->makeFriend($user->id, $friend->id);

        $params = [
            'title' => "Lorem ipsum dolor sit amet",
            'description' => "Lorem ipsum dolor sit amet description",
            'next_expected_date' => "2018/12/12 10:10 PM"
        ];

        $response = $this->post('/contact/' . $friend->id . '/reminder', $params);
        $response->assertRedirect('/' . $friend->username . '?tab=reminders');

        // Check the reminder has been added
        $params['next_expected_date'] = "2018-12-12 22:10:00";
        $this->assertDatabaseHas('reminders', $params);
    }

    public function testCanEditSuccess()
    {
        $user = $this->logIn();

        $friend = factory(User::class)->create();

        $this->makeFriend($user->id, $friend->id);

        $reminder = factory(Reminder::class)->create([
            'from_user_id' => $user->id,
            'to_user_id' => $friend->id
        ]);

        $params = [
            'title' => 'This is a reminder title',
            'description' => 'This is a reminder description',
            'next_expected_date' => "2018/12/12 10:10 PM"
        ];

        $response = $this->put('/contact/' . $friend->id . '/reminder/' . $reminder->id, $params);
        $response->assertRedirect('/' . $friend->username . '?tab=reminders');

        // Assert the reminder has been updated
        $params['next_expected_date'] = "2018-12-12 22:10:00";
        $this->assertDatabaseHas('reminders', $params);
    }

    public function testCanDeleteSuccess()
    {
        $user = $this->logIn();

        $friend = factory(User::class)->create();

        $this->makeFriend($user->id, $friend->id);

        $reminder = factory(Reminder::class)->create([
            'from_user_id' => $user->id,
            'to_user_id' => $friend->id
        ]);

        $response = $this->delete('/contact/' . $friend->id . '/reminder/' . $reminder->id);
        $response->assertRedirect('/' . $friend->username . '?tab=reminders');

        // Assert the reminder has been deleted
        $this->assertDatabaseMissing('reminders', $reminder->toArray());
    }
}
