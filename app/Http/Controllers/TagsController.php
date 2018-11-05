<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;

class TagsController extends Controller
{
    /**
     * Get tags.
     *
     * @param User $user
     * @return \Illuminate\Http\JsonResponse
     */
    public function list(User $user)
    {
        $tags = auth()->user()->tagged($user)->pluck('tag.name');

        return response()->json([
            'tags' => $tags,
        ]);
    }

    /**
     * Update tags.
     *
     * @param Request $request
     * @param User $user
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, User $user)
    {
        $creatorUser = auth()->user();
        $tags = $request->tags;

        // if we receive an empty array, that means all tags have been removed.
        if (empty($tags)) {
            $creatorUser->detachTags($user);
            return response()->json(['tags' => '']);
        }

        foreach ($creatorUser->tagged($user) as $userTag) {
            // remove tags was not submitted.
            if (!in_array($userTag->tag->name, $tags)) {
                $creatorUser->detachTag($user, $userTag->tag);
            }
        }

        $insertedTags = [];
        foreach ($tags as $tagName) {
            $creatorUser->attachTag($user, $tagName);

            // return inserted tags.
            array_push($insertedTags, $tagName);
        }

        return response()->json([
            'tags' => $insertedTags,
        ]);
    }
}
