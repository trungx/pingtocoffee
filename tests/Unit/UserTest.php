<?php

namespace Tests\Unit;

use App\Helpers\DateHelper;
use App\Reminder;
use Tests\TestCase;
use App\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    public function testGetRemindersCorrect()
    {
        // Create user with Asia/Bangkok timezone
        $from_user = factory(User::class)->create([
            'timezone' => 'Asia/Bangkok'
        ]);

        $to_user = factory(User::class)->create();

        $reminder = factory(Reminder::class)->create([
            'from_user_id' => $from_user->id,
            'to_user_id' => $to_user->id
        ]);

        $this->assertEquals(
            DateHelper::convertToTimezone($reminder->next_expected_date, 'Asia/Bangkok')->toDateString(),
            $from_user->getReminders($to_user->id)->first()->next_expected_date->toDateString()
        );

        $reminder->frequency_number = 1;
        $reminder->frequency_type = 'once';
        $reminder->save();
        $this->assertEquals(
            'Once time',
            $from_user->getReminders($to_user->id)->first()->frequency_type
        );

        $reminder->frequency_number = 1;
        $reminder->frequency_type = 'day';
        $reminder->save();
        $this->assertEquals(
            'Every day',
            $from_user->getReminders($to_user->id)->first()->frequency_type
        );

        $reminder->frequency_number = 10;
        $reminder->frequency_type = 'week';
        $reminder->save();
        $this->assertEquals(
            'Every 10 weeks',
            $from_user->getReminders($to_user->id)->first()->frequency_type
        );
    }

    public function testCompleteNameReturnCorrect()
    {
        $user = factory(User::class)->create([
            'first_name' => 'Henry',
            'last_name' => 'Bui'
        ]);

        $this->assertEquals('Henry Bui', $user->getCompleteName());
    }

    public function testIsBirthdayTodayReturnCorrect()
    {
        $user = factory(User::class)->create([
            'first_name' => 'Henry',
            'last_name' => 'Bui',
            'birthday' => '1993-01-01',
        ]);

        // Set test day.
        Carbon::setTestNow(Carbon::create(2018, 1, 1));

        $this->assertEquals(true, $user->isBirthdayToday());
    }
}
