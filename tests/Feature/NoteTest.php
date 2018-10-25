<?php

namespace Tests\Feature;

use App\Note;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\FeatureTestcase;

class NoteTest extends FeatureTestcase
{
    use RefreshDatabase;

    public function testCanAddSuccess()
    {
        $user = $this->logIn();

        $contact = factory(User::class)->create();

        $this->makeFriend($user->id, $contact->id);

        $params = [
            'note' => "Today is a beautiful day",
        ];

        $response = $this->post('/contact/' . $contact->id . '/note', $params);
        $response->assertRedirect('/' . $contact->username . '?tab=notes');

        // Check the reminder has been added
        $params['note'] = "Today is a beautiful day";
        $this->assertDatabaseHas('notes', $params);
    }

    public function testCanDeleteSuccess()
    {
        $user = $this->logIn();

        $contact = factory(User::class)->create();

        $this->makeFriend($user->id, $contact->id);

        $note = factory(Note::class)->create([
            'from_user_id' => $user->id,
            'to_user_id' => $contact->id
        ]);

        $response = $this->delete('/contact/' . $contact->id . '/note/' . $note->id);
        $response->assertRedirect('/' . $contact->username . '?tab=notes');

        // Assert the note has been deleted
        $this->assertDatabaseMissing('notes', $note->toArray());
    }
}
