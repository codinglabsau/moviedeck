<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

class RegisteredUserTest extends TestCase
{

    use RefreshDatabase;

    /** @test */
    public function a_user_can_register()
    {
        $user = [
            'name' => 'Jaydel',
            'email' => 'testemail@test.com',
            'password' => 'passwordtest',
            'password_confirmation' => 'passwordtest'
        ];

        $response = $this->post('/register', $user);

        $response->assertRedirect('/');

        $this->assertDatabaseHas('users', [
            'name' => 'Jaydel',
            'email' => 'testemail@test.com',
        ]);
    }


    /** @test */
    public function only_a_registered_user_can_see_content()
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->getJson('/home')
            ->assertOk();
    }

    /** @test */
    public function non_registered_users_cannot_see_content()
    {
        $this->getJson('/home')
            ->assertStatus(401);
    }
}
