<?php

namespace Tests\Http\Controllers;

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
            ->get(route('movies.create'))
            ->assertRedirect('/');
    }

    /** @test */
    public function an_admin_can_add_a_movie()
    {
        $admin = User::factory()->admin()->create();

        $this->actingAs($admin)
             ->postJson('/movies', [
                 'title' => 'Praesent elementum facilisis leo vel!',
                 'synopsis' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Quam elementum pulvinar etiam non quam lacus suspendisse faucibus. Purus sit amet luctus venenatis lectus magna fringilla.',
                 'year' => 2019,
                 'poster' => 'https://townsquare.media/site/442/files/2019/08/jurassic-world-1.jpg?w=980&q=75',
                 'banner' => 'https://wallpaperaccess.com/full/1707195.jpg',
                 'trailer' => 'https://www.youtube.com/watch?v=Da3STcxIUqw&list=PLuAiHxLeTqiTeCoAiB39PUYALbxKprq6e&index=10',
                 'duration' => '190',
                 'genres' => [ 0 => "1" ],
                 'celebs' => [ 0 => "1" ],
                 'characters' => [ 0 => "Test 1" ],
             ])
            ->assertRedirect()
            ->assertSessionHas('message', 'Success! Movie has been added.');

        $this->assertDatabaseHas('movies', [
            'title' => 'Praesent elementum facilisis leo vel!',
            'synopsis' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Quam elementum pulvinar etiam non quam lacus suspendisse faucibus. Purus sit amet luctus venenatis lectus magna fringilla.',
            'year' => 2019,
            'poster' => 'https://townsquare.media/site/442/files/2019/08/jurassic-world-1.jpg?w=980&q=75',
            'banner' => 'https://wallpaperaccess.com/full/1707195.jpg',
            'trailer' => 'https://www.youtube.com/watch?v=Da3STcxIUqw&list=PLuAiHxLeTqiTeCoAiB39PUYALbxKprq6e&index=10',
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
                'title' => 'Praesent elementum facilisis leo vel!',
                'synopsis' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Quam elementum pulvinar etiam non quam lacus suspendisse faucibus. Purus sit amet luctus venenatis lectus magna fringilla.',
                'year' => 2019,
                'poster' => 'https://townsquare.media/site/442/files/2019/08/jurassic-world-1.jpg?w=980&q=75',
                'banner' => 'https://wallpaperaccess.com/full/1707195.jpg',
                'trailer' => 'https://www.youtube.com/watch?v=Da3STcxIUqw&list=PLuAiHxLeTqiTeCoAiB39PUYALbxKprq6e&index=10',
                'duration' => '190',
                'genres' => [ 0 => "1" ],
                'celebs' => [ 0 => "1" ],
                'characters' => [ 0 => "Test 1" ],
            ])
            ->assertRedirect('/');

        $this->assertDatabaseMissing('movies', [
            'title' => 'Praesent elementum facilisis leo vel!',
            'synopsis' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Quam elementum pulvinar etiam non quam lacus suspendisse faucibus. Purus sit amet luctus venenatis lectus magna fringilla.',
            'year' => 2019,
            'poster' => 'https://townsquare.media/site/442/files/2019/08/jurassic-world-1.jpg?w=980&q=75',
            'banner' => 'https://wallpaperaccess.com/full/1707195.jpg',
            'trailer' => 'https://www.youtube.com/watch?v=Da3STcxIUqw&list=PLuAiHxLeTqiTeCoAiB39PUYALbxKprq6e&index=10',
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
            ->assertRedirect('/');
    }

    /** @test */
    public function an_admin_can_update_a_movie()
    {
        $admin = User::factory()->admin()->create();
        $movie = Movie::factory()->create([
            'title' => 'Praesent elementum facilisis leo vel!',
            'synopsis' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Quam elementum pulvinar etiam non quam lacus suspendisse faucibus. Purus sit amet luctus venenatis lectus magna fringilla.',
            'year' => 2019,
            'poster' => 'https://townsquare.media/site/442/files/2019/08/jurassic-world-1.jpg?w=980&q=75',
            'banner' => 'https://wallpaperaccess.com/full/1707195.jpg',
            'trailer' => 'https://www.youtube.com/watch?v=Da3STcxIUqw&list=PLuAiHxLeTqiTeCoAiB39PUYALbxKprq6e&index=10',
            'duration' => '190',
        ]);

        $this->actingAs($admin)
            ->putJson("/movies/{$movie->id}", [
                'title' => 'Update Praesent elementum facilisis leo vel!',
                'synopsis' => 'Update Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Quam elementum pulvinar etiam non quam lacus suspendisse faucibus. Purus sit amet luctus venenatis lectus magna fringilla.',
                'year' => 2019,
                'poster' => 'https://townsquare.media/site/442/files/2019/08/jurassic-world-1.jpg?w=980&q=75',
                'banner' => 'https://wallpaperaccess.com/full/1707195.jpg',
                'trailer' => 'https://www.youtube.com/watch?v=Da3STcxIUqw&list=PLuAiHxLeTqiTeCoAiB39PUYALbxKprq6e&index=10',
                'duration' => '190',
                'genres' => [ 0 => "1" ],
                'celebs' => [ 0 => "1" ],
                'characters' => [ 0 => "Test 1" ],
            ])
            ->assertRedirect()
            ->assertSessionHas('message', 'Success! Movie has been updated.');

        $this->assertDatabaseHas('movies', [
            'title' => 'Update Praesent elementum facilisis leo vel!',
            'synopsis' => 'Update Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Quam elementum pulvinar etiam non quam lacus suspendisse faucibus. Purus sit amet luctus venenatis lectus magna fringilla.',
            'year' => 2019,
            'poster' => 'https://townsquare.media/site/442/files/2019/08/jurassic-world-1.jpg?w=980&q=75',
            'banner' => 'https://wallpaperaccess.com/full/1707195.jpg',
            'trailer' => 'https://www.youtube.com/watch?v=Da3STcxIUqw&list=PLuAiHxLeTqiTeCoAiB39PUYALbxKprq6e&index=10',
            'duration' => '190',
        ]);
    }

    /** @test */
    public function a_user_cannot_update_a_movie()
    {
        $user = User::factory()->create([
            'is_admin' => false
        ]);

        $movie = Movie::factory()->create([
            'title' => 'Praesent elementum facilisis leo vel!',
            'synopsis' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Quam elementum pulvinar etiam non quam lacus suspendisse faucibus. Purus sit amet luctus venenatis lectus magna fringilla.',
            'year' => 2019,
            'poster' => 'https://townsquare.media/site/442/files/2019/08/jurassic-world-1.jpg?w=980&q=75',
            'banner' => 'https://wallpaperaccess.com/full/1707195.jpg',
            'trailer' => 'https://www.youtube.com/watch?v=Da3STcxIUqw&list=PLuAiHxLeTqiTeCoAiB39PUYALbxKprq6e&index=10',
            'duration' => '190',
        ]);

        $this->actingAs($user)
            ->putJson("/movies/{$movie->id}", [
                'title' => 'Update Praesent elementum facilisis leo vel!',
                'synopsis' => 'Update Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Quam elementum pulvinar etiam non quam lacus suspendisse faucibus. Purus sit amet luctus venenatis lectus magna fringilla.',
                'year' => 2019,
                'poster' => 'https://townsquare.media/site/442/files/2019/08/jurassic-world-1.jpg?w=980&q=75',
                'banner' => 'https://wallpaperaccess.com/full/1707195.jpg',
                'trailer' => 'https://www.youtube.com/watch?v=Da3STcxIUqw&list=PLuAiHxLeTqiTeCoAiB39PUYALbxKprq6e&index=10',
                'duration' => '190',
                'genres' => [ 0 => "1" ],
                'celebs' => [ 0 => "1" ],
                'characters' => [ 0 => "Test 1" ],
            ])->assertRedirect();

        $this->assertDatabaseMissing('movies', [
            'title' => 'Update Praesent elementum facilisis leo vel!',
            'synopsis' => 'Update Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Quam elementum pulvinar etiam non quam lacus suspendisse faucibus. Purus sit amet luctus venenatis lectus magna fringilla.',
            'year' => 2019,
            'poster' => 'https://townsquare.media/site/442/files/2019/08/jurassic-world-1.jpg?w=980&q=75',
            'banner' => 'https://wallpaperaccess.com/full/1707195.jpg',
            'trailer' => 'https://www.youtube.com/watch?v=Da3STcxIUqw&list=PLuAiHxLeTqiTeCoAiB39PUYALbxKprq6e&index=10',
            'duration' => '190',
        ]);
    }

    /** @test */
    public function an_admin_can_delete_a_movie()
    {
        $admin = User::factory()->admin()->create();
        $movie = Movie::factory()->create();

        $this->actingAs($admin)
            ->delete("/movies/{$movie->id}")
                ->assertRedirect()
                ->assertSessionHas('message', 'Success! Movie has been deleted.');

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
            ->assertRedirect();

        $this->assertDatabaseHas('movies', [
            'id' => $movie->id,
        ]);
    }
}
