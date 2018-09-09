<?php

namespace Tests;

use App\User;
use App\Relationship;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class FeatureTestcase extends TestCase
{
    use DatabaseTransactions;

    public function logIn()
    {
        $user = factory(User::class)->create();

        $this->actingAs($user);

        return $user;
    }

    public function makeFriend($user_first_id, $user_second_id)
    {
        if ($user_first_id > $user_second_id) {
            $tmp_id = $user_first_id;
            $user_first_id = $user_second_id;
            $user_second_id = $tmp_id;
        }

        // Relationship need to determine to make sure they are friends
        Relationship::create([
            'user_first_id' => $user_first_id,
            'user_second_id' => $user_second_id,
            'type' => Relationship::FRIENDS_TYPE
        ]);
    }
}
