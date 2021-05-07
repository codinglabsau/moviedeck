<?php

namespace Tests\Http\Controllers\Auth;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

class LoginControllerTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function login_displays_the_login_form()
    {
        $this->get(route('login'))
             ->assertOk()
             ->assertViewIs('auth.login');
    }

    /** @test */
    public function login_displays_validation_errors()
    {
        $this->post('/login', [])
             ->assertStatus(302)
             ->assertSessionHasErrors('email');
    }

    /** @test */
    public function login_authenticates_and_redirects_user()
    {
        $user = User::factory()->create();

        $this->post(route('login'), [
            'email' => $user->email,
            'password' => 'password'
        ])->assertRedirect(route('home'));;

        $this->assertAuthenticatedAs($user);
    }
}
