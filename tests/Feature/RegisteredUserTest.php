<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class RegisteredUserTest extends TestCase
{

    use DatabaseMigrations;

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
