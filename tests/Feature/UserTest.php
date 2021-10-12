<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Http\Response;
use Tests\TestCase;

class UserTest extends TestCase
{
    private $user;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create();
    }
    public function testCreateNewUser()
    {
        $this->post('/api/users', [
            'name' => 'Test User',
            'address' => 'Amsterdam - NL',
            'contact' => '56681984',
            'email' => 'testuser@test.com',
            'password' => '123456',
        ])
            ->assertStatus(Response::HTTP_CREATED)
            ->assertJsonStructure([
                'id',
                'name',
                'address',
                'contact',
                'email',
            ]);
    }
}
