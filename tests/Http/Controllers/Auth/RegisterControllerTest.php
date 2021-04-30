<?php

namespace Tests\Http\Controllers\Auth;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class RegisterControllerTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function user_is_created_when_they_register()
    {
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
}
