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
    public function an_admin_can_see_movies_view()
    {
        $this->withoutExceptionHandling();
        $admin = \App\Models\User::factory()->admin()->create();

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
            ->get(route('movies.create'))
            ->assertForbidden();
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

        $this->assertDatabaseHas('movies', [
            'title' => 'Sample Movie',
            'synopsis' => 'This is a Sample Synopsis',
            'year' => 2021,
            'poster' => 'https://via.placeholder.com/600x750.png/00aa33?text=totam',
            'trailer' => 'http://www.goyette.biz/',
            'duration' => '190',
        ]);
    }

    /** @test */
    public function a_user_cannot_add_a_movie()
    {
        $user = User::factory()->create([
            'is_admin' => false
        ]);

        $this->actingAs($user)
            ->postJson('/movies', [
                'title' => 'Sample Movie',
                'synopsis' => 'This is a Sample Synopsis',
                'year' => 2021,
                'poster' => 'https://via.placeholder.com/600x750.png/00aa33?text=totam',
                'trailer' => 'http://www.goyette.biz/',
                'duration' => '190',
            ])->assertForbidden();

        $this->assertDatabaseMissing('movies', [
            'title' => 'Sample Movie',
            'synopsis' => 'This is a Sample Synopsis',
            'year' => 2021,
            'poster' => 'https://via.placeholder.com/600x750.png/00aa33?text=totam',
            'trailer' => 'http://www.goyette.biz/',
            'duration' => '190',
        ]);
    }

    /** @test */
    public function an_admin_can_see_edit_movie_view()
    {
        $movie = Movie::factory()->create();
        $admin = User::factory()->admin()->create();

        $this->actingAs($admin)
            ->get("/movies/{$movie->id}/edit")
            ->assertOk();
    }

    /** @test */
    public function a_user_cannot_see_edit_movie_view()
    {
        $movie = Movie::factory()->create();
        $user = User::factory()->create([
            'is_admin' => false
        ]);

        $this->actingAs($user)
            ->get("/movies/{$movie->id}/edit")
            ->assertForbidden();
    }

    /** @test */
    public function an_admin_can_update_a_movie()
    {
        $admin = User::factory()->admin()->create();
        $movie = Movie::factory()->create([
            'title' => 'Epic Movie Title',
            'synopsis' => 'This is the synopsis of the epic movie.',
            'year' => 2021,
            'poster' => 'https://via.placeholder.com/600x750.png/00aa33?text=totam',
            'trailer' => 'http://www.goyette.biz/',
            'duration' => '160',
        ]);

        $this->actingAs($admin)
            ->putJson("/movies/{$movie->id}", [
                'title' => 'Sample Updated Movie Title',
                'synopsis' => 'This is a Sample Updated Synopsis of epic movie',
                'year' => 2021,
                'poster' => 'https://via.placeholder.com/600x750.png/00aa33?text=totam',
                'trailer' => 'http://www.goyette.biz/',
                'duration' => '160',
            ])->assertOk();

        $this->assertDatabaseHas('movies', [
            'title' => 'Sample Updated Movie Title',
            'synopsis' => 'This is a Sample Updated Synopsis of epic movie',
            'year' => 2021,
            'poster' => 'https://via.placeholder.com/600x750.png/00aa33?text=totam',
            'trailer' => 'http://www.goyette.biz/',
            'duration' => '160',
        ]);
    }

    /** @test */
    public function a_user_cannot_update_a_movie()
    {
        $user = User::factory()->create([
            'is_admin' => false
        ]);

        $movie = Movie::factory()->create([
            'title' => 'Epic Movie Title',
            'synopsis' => 'This is the synopsis of the epic movie.',
            'year' => 2021,
            'poster' => 'https://via.placeholder.com/600x750.png/00aa33?text=totam',
            'trailer' => 'http://www.goyette.biz/',
            'duration' => '160',
        ]);

        $this->actingAs($user)
            ->putJson("/movies/{$movie->id}", [
                'title' => 'Sample Updated Movie Title',
                'synopsis' => 'This is a Sample Updated Synopsis of epic movie',
                'year' => 2021,
                'poster' => 'https://via.placeholder.com/600x750.png/00aa33?text=totam',
                'trailer' => 'http://www.goyette.biz/',
                'duration' => '160',
            ])->assertForbidden();

        $this->assertDatabaseMissing('movies', [
            'title' => 'Sample Updated Movie Title',
            'synopsis' => 'This is a Sample Updated Synopsis of epic movie',
            'year' => 2021,
            'poster' => 'https://via.placeholder.com/600x750.png/00aa33?text=totam',
            'trailer' => 'http://www.goyette.biz/',
            'duration' => '160',
        ]);
    }

    /** @test */
    public function an_admin_can_delete_a_movie()
    {
        $admin = User::factory()->admin()->create();
        $movie = Movie::factory()->create();

        $this->actingAs($admin)
            ->delete("/movies/{$movie->id}")
                ->assertOk();

        $this->assertDatabaseMissing('movies', [
            'id' => $movie->id,
        ]);
    }

    /** @test */
    public function a_user_cannot_delete_a_movie()
    {
        $user = User::factory()->create([
            'is_admin' => false
        ]);

        $movie = Movie::factory()->create();

        $this->actingAs($user)
            ->delete("/movies/{$movie->id}")
            ->assertForbidden();

        $this->assertDatabaseHas('movies', [
            'id' => $movie->id,
        ]);
    }
}
