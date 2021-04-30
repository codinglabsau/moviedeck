<?php

namespace Tests\Http\Middleware;

use Tests\TestCase;
use App\Models\User;
use App\Models\Movie;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AdminMovieTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function an_admin_can_access_movies_view()
    {
        $admin = User::factory()->admin()->create();

        $this->actingAs($admin)
            ->get('/movies')
            ->assertOk();
    }

    /** @test */
    public function a_user_can_access_movies_view()
    {
        $user = User::factory()->create([
            'is_admin' => false,
        ]);

        $this->actingAs($user)
            ->get('/movies')
            ->assertOk();
    }

    /** @test */
    public function a_guest_can_access_movies_view()
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

    /** @test */
    public function a_guest_cannot_access_create_movie_view()
    {
        $this->get('/movies/create')
            ->assertRedirect();
    }

    /** @test */
    public function an_admin_can_access_edit_movie_view()
    {
        $movie = Movie::factory()->create();
        $admin = User::factory()->admin()->create();

        $this->actingAs($admin)
            ->get("/movies/{$movie->id}/edit")
            ->assertOk();
    }

    /** @test */
    public function a_user_cannot_access_edit_movie_view()
    {
        $movie = Movie::factory()->create();
        $user = User::factory()->create([
            'is_admin' => false
        ]);

        $this->actingAs($user)
            ->get("/movies/{$movie->id}/edit")
            ->assertRedirect();
    }

    /** @test */
    public function a_guest_cannot_access_edit_movie_view()
    {
        $movie = Movie::factory()->create();

        $this->get("/movies/{$movie->id}/edit")
            ->assertRedirect();
    }
}
