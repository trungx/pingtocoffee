<?php

namespace App\Http\Controllers;

use App\User;
use App\Event;
use App\Relationship;

class RelationshipsController extends Controller
{
    /**
     * Store new relationship
     *
     * @param User $user
     * @return array
     */
    public function store(User $user)
    {
        $sortedUsers = collect([auth()->user(), $user])->sortBy('id');

        if (auth()->user()->id < $user->id) {
            $type = Relationship::PENDING_FIRST_SECOND_TYPE;
        } else {
            $type = Relationship::PENDING_SECOND_FIRST_TYPE;
        }

        // Set new relationship.
        Relationship::firstOrCreate([
            'user_first_id' => $sortedUsers->first()->id,
            'user_second_id' => $sortedUsers->last()->id,
            'type' => $type
        ]);

        return ['type' => $type];
    }

    /**
     * Accept relationship
     *
     * @param User $user
     * @return array
     */
    public function update(User $user)
    {
        $sortedUsers = collect([auth()->user(), $user])->sortBy('id');

        Relationship::where('user_first_id', $sortedUsers->first()->id)
            ->where('user_second_id', $sortedUsers->last()->id)
            ->update(['type' => Relationship::FRIENDS_TYPE]);

        // Create event log
        $user->createLogForFeed(auth()->user()->id, $user->id, Event::ADD_ACTION);

        return ['type' => Relationship::FRIENDS_TYPE];
    }

    /**
     * Delete relationship
     *
     * @param User $user
     * @return array
     */
    public function destroy(User $user)
    {
        $sortedUsers = collect([auth()->user(), $user])->sortBy('id');

        Relationship::where('user_first_id', $sortedUsers->first()->id)
            ->where('user_second_id', $sortedUsers->last()->id)
            ->delete();

        return ['type' => Relationship::NONE];
    }

    /**
     * Block relationship
     *
     * @param User $user
     * @return array
     */
    public function block(User $user)
    {
        $sortedUsers = collect([auth()->user(), $user])->sortBy('id');
        $data = [
            'user_first_id' => $sortedUsers->first()->id,
            'user_second_id' => $sortedUsers->last()->id,
            'type' => Relationship::BLOCK_TYPE,
        ];
        
        Relationship::create($data);

        return ['type' => Relationship::BLOCK_TYPE];
    }
}
