<?php

namespace Tests\Feature;

use Illuminate\Contracts\Hashing\Hasher;
use Tests\FeatureTestcase;

class UserTest extends FeatureTestcase
{
    public function testCreateUserAndRedirectCorrect()
    {
        $params = [
            'first_name' => 'Henry',
            'last_name' => 'Bui',
            'email' => 'henry.bui@pingtocoffee.com'
        ];

        $response = $this->post('/register', $params);
        $response->assertRedirect('/');
    }
}
