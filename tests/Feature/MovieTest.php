<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Movie;
use Illuminate\Foundation\Testing\RefreshDatabase;

class MovieTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function an_admin_can_see_movies()
    {
        $admin = User::factory()->admin()->create();

        $this->actingAs($admin)
            ->get('/movies')
            ->assertOk();
    }

    /** @test */
    public function an_admin_can_create_a_movie()
    {
        $admin = User::factory()->admin()->create();

        $this->actingAs($admin)
            ->get('/movies/create')
            ->assertOk();
    }

    /** @test */
    public function a_non_admin_cannot_create_a_movie()
    {
        $user = User::factory()->create([
            'is_admin' => false
        ]);

        $this->actingAs($user)
            ->get('/movies/create')
            ->assertStatus(403);
    }

    /** @test */
    public function an_admin_can_add_a_movie()
    {
        $admin = User::factory()->admin()->create();

        $this->actingAs($admin)
            ->postJson('/movies', [
                'title' => 'Sample Movie',
                'synopsis' => 'This is a Sample Synopsis',
                'year' => 2021,
                'poster' => 'https://via.placeholder.com/600x750.png/00aa33?text=totam',
                'trailer' => 'http://www.goyette.biz/',
                'duration' => '190',
            ])->assertOk();
    }

    /** @test */
    public function a_non_admin_cannot_edit_a_movie()
    {
        $user = User::factory()->create([
            'is_admin' => false
        ]);

        $this->actingAs($user)
            ->get('/movies/edit')
            ->assertStatus(403);
    }

    /** @test */
    public function an_admin_can_edit_a_movie()
    {
        $admin = User::factory()->admin()->create();

        $this->actingAs($admin)
            ->get('/movies/edit')
            ->assertOk();
    }

    /** @test */
    public function an_admin_can_update_a_movie()
    {
        $admin = User::factory()->admin()->create();
        $movie = Movie::factory()->create();

        $this->actingAs($admin)
            ->putJson("/movies/{$movie->id}", [
                'title' => 'Sample Updated Movie',
                'synopsis' => 'This is a Sample Synopsis',
                'year' => 2009,
                'poster' => 'https://via.placeholder.com/600x750.png/00aa33?text=totam',
                'trailer' => 'http://www.goyette.biz/',
                'duration' => '190',
            ])->assertOk();
    }

    /** @test */
    public function an_admin_can_delete_a_movie()
    {
        $admin = User::factory()->admin()->create();
        $movie = Movie::factory()->create();

        $this->actingAs($admin)
            ->delete("/movies/{$movie->id}")
                ->assertOk();
    }
}
