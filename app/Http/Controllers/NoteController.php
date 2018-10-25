<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Note;

class NoteController extends Controller
{
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, User $user)
    {
        $noteData = [
            'from_user_id' => auth()->user()->id,
            'to_user_id' => $user->id,
            'note' => htmlspecialchars($request->note),
        ];

        $note = Note::create($noteData);

        return redirect('/' . $user->username . '?tab=notes')
            ->with('success', trans('user.notes_add_success'));
    }

    /**
     *
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user, Note $note)
    {
        try {
            $note->delete();
            return redirect('/' . $user->username . '?tab=notes')->with('success', trans('user.notes_delete_success'));
        } catch (\Exception $e) {
            return redirect('/' . $user->username . '?tab=notes')->with('error', trans('user.something_wrong'));
        }
    }
}
