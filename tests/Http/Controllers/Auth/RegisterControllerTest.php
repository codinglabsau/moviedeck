<?php

namespace Tests\Http\Controllers\Auth;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class RegisterControllerTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function user_is_created_when_they_register()
    {
        $this->withoutExceptionHandling();

        $response = $this->postJson('/register', [
            'name' => 'Joseph Hand',
            'email' => 'joseph.hand@example.com',
            'password' => 'secretPass',
            'password_confirmation' => 'secretPass'
        ]);

        $response->assertRedirect('/');

        $this->assertDatabaseHas('users', [
            'name' => 'Joseph Hand',
            'email' => 'joseph.hand@example.com'
        ]);
    }

    /** @test */
//    public function only_an_authenticated_user_can_see_profile_view()
//    {
//        $this->withoutExceptionHandling();
//
//        $this->getJson('home')
//             ->assertStatus(401);
//
//        $user = \App\Models\User::factory()->create();
//
//        $this->actingAs($user)
//             ->getJson('home')
//             ->assertOk();
//    }
}
