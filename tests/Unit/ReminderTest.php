<?php

namespace Tests\Unit;

use App\Reminder;
use Tests\TestCase;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ReminderTest extends TestCase
{
    use RefreshDatabase;

    public function testTitleReturnNullIfUndefined()
    {
        $reminder = new Reminder();

        $this->assertNull($reminder->title);
    }

    public function testTitleReturnCorrectString()
    {
        $reminder = new Reminder();
        $reminder->title = "Lorem ipsum dolor sit amet";

        $this->assertEquals("Lorem ipsum dolor sit amet", $reminder->title);
    }

    public function testDescriptionReturnNullIfUndefined()
    {
        $reminder = new Reminder();

        $this->assertNull($reminder->description);
    }

    public function testDescriptionReturnCorrectString()
    {
        $reminder = new Reminder();
        $reminder->description = "Proin et metus at ex rhoncus accumsan non in massa.";

        $this->assertEquals("Proin et metus at ex rhoncus accumsan non in massa.", $reminder->description);
    }

    public function testNextExpectedDateReturnCorrectValue()
    {
        $reminder = new Reminder;

        // Set test date
        Carbon::setTestNow(Carbon::create(2018, 1, 1));

        $this->assertEquals('2018-01-01', $reminder->next_expected_date->toDateString());
    }

    public function testCalculateCorrectNextExpectedDate()
    {
        $reminder = new Reminder;
        $reminder->frequency_number = 1;

        // Set test date
        Carbon::setTestNow(Carbon::create(2018, 1, 1));

        $reminder->next_expected_date = '2010-01-01 12:00:00';
        $reminder->frequency_type = 'day'; // add 2923 days
        $this->assertEquals('2018-01-02', $reminder->calculateNextExpectedDate()->next_expected_date->toDateString());

        $reminder->next_expected_date = '2010-01-01 12:00:00';
        $reminder->frequency_type = 'week'; // add 418 weeks
        $this->assertEquals('2018-01-05', $reminder->calculateNextExpectedDate()->next_expected_date->toDateString());

        $reminder->next_expected_date = '2010-01-01 12:00:00';
        $reminder->frequency_type = 'month'; // add 97 months
        $this->assertEquals('2018-02-01', $reminder->calculateNextExpectedDate()->next_expected_date->toDateString());

        $reminder->next_expected_date = '2010-01-01 12:00:00';
        $reminder->frequency_type = 'year'; // add 9 years
        $this->assertEquals('2019-01-01', $reminder->calculateNextExpectedDate()->next_expected_date->toDateString());
    }
}
