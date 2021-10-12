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

    public function testGetUser()
    {
        $this->get('/api/users/' . $this->user->id)
            ->assertStatus(Response::HTTP_OK)
            ->assertJson([
                'id' => $this->user->id,
                'name' => $this->user->name,
                'address' => $this->user->address,
                'contact' => $this->user->contact,
                'email' => $this->user->email,
            ]);
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
