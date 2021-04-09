<?php

namespace Tests\Feature\Http\Controllers\Auth;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class RegisterControllerTest extends TestCase
{
    /** @test */
    public function user_is_created_when_they_register()
    {
        $response = $this->getJson('/register');

        $response->assertJsonFragment([
            'name' => 'Joseph Hand',
            'email' => 'joseph.hand@example.com',
            'password' => 'secret'
        ]);
    }
}
