<?php

namespace App\Http\Controllers;

use App\Event;
use Illuminate\Http\Request;
use App\User;
use App\Note;

class NoteController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @param User $user
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request, User $user)
    {
        $noteData = [
            'from_user_id' => auth()->user()->id,
            'to_user_id' => $user->id,
            'note' => htmlspecialchars($request->note),
        ];

        $note = Note::create($noteData);

        // Create event log
        $note->createLogForFeed(Event::ADD_ACTION);

        return redirect('/' . $user->username . '?tab=notes')
            ->with('success', trans('user.notes_add_success'));
    }

    /**
     * Delete a resource in storage.
     *
     * @param User $user
     * @param Note $note
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(User $user, Note $note)
    {
        try {
            $note->delete();

            // Create event log
            $note->createLogForFeed(Event::DELETE_ACTION);

            return redirect('/' . $user->username . '?tab=notes')
                ->with('success', trans('user.notes_delete_success'));
        } catch (\Exception $e) {
            return redirect('/' . $user->username . '?tab=notes')
                ->with('error', trans('user.something_wrong'));
        }
    }
}
