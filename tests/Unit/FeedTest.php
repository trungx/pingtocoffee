<?php

namespace Tests\Unit;

use App\Feed;
use Tests\Testcase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class FeedTest extends Testcase
{
    use RefreshDatabase;

    public function testAddSuccessFeedToDatabase()
    {
        // Create factory
        $event = \App\DefaultEvent::all()->random();
        $user = factory(\App\User::class)->create();

        // Add event to feed
        $feed = new Feed();
        $feed->add($event, $user->id);

        $data = [
            'user_id' => $user->id,
            'feedable_id' => $event->id,
            'feedable_type' => 'App\DefaultEvent'
        ];

        $this->assertDatabaseHas('feeds', $data);
    }

    public function testGetObjectDataReturnsAnObject()
    {
        // Create factory
        $event = \App\DefaultEvent::all()->random();
        $user = factory(\App\User::class)->create();

        $this->actingAs($user);

        // Add event to feed
        $feed = (new Feed)->add($event, $user->id);

        $data = [
            'body' => __('dashboard.' . $event->body),
            'icon_class' => __('dashboard.' . $event->icon_class),
            'calendar' => $event->created_at
                ->copy()
                ->setTimezone($user->timezone)
                ->format('M d'),
        ];

        $this->assertEquals($data, $feed->getObjectData());
    }
}
