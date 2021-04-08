<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserRegistrationTest extends TestCase
{

//    use RefreshDatabase;

    /** @test */
    public function a_registered_user_can_see_content()
    {
        $response = $this->get('/home');
        if (Auth::check()) {
            $response->assertSee('Dashboard');
        } else {
            $response->assertDontSee('Dashboard');
        }
    }
}
