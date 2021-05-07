<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Movie;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AdminMovieTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function an_admin_can_see_movies_view()
    {
        $admin = User::factory()->admin()->create();

        $this->actingAs($admin)
            ->get('/movies')
            ->assertOk();
    }

    /** @test */
    public function a_user_can_see_movies_view()
    {
        $user = User::factory()->create([
            'is_admin' => false,
        ]);

        $this->actingAs($user)
            ->get('/movies')
            ->assertOk();
    }

    /** @test */
    public function an_admin_can_access_create_movie_view()
    {
        $admin = User::factory()->admin()->create();

        $this->actingAs($admin)
            ->get('/movies/create')
            ->assertOk();
    }

    /** @test */
    public function a_user_cannot_access_create_movie_view()
    {
        $user = User::factory()->create([
            'is_admin' => false
        ]);

        $this->actingAs($user)
            ->get('/movies/create')
            ->assertRedirect();
    }
}
