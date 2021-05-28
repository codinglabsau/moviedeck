<?php

namespace Tests\Feature\Http\Controllers;

use Tests\TestCase;
use App\Models\User;
use App\Models\Movie;
use App\Models\MovieUser;
use Illuminate\Foundation\Testing\RefreshDatabase;

class WatchlistTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function user_can_see_their_own_watchlist_index_view()
    {
        $user = User::factory()->create([
            'is_admin' => false
        ]);

        $this->actingAs($user)
            ->getJson(route('watchlist.index', $user->id))
            ->assertOk();
    }

    /** @test */
    public function admin_cannot_see_others_watchlist_index_view()
    {
        $admin = User::factory()->admin()->create();
        $user = User::factory()->create();

        $this->actingAs($admin)
            ->getJson(route('watchlist.index', $user->id))
            ->assertRedirect('/');
    }

    /** @test */
    public function user_cannot_see_others_watchlist_index_view()
    {
        $user1 = User::factory()->create([
            'is_admin' => false
        ]);
        $user2 = User::factory()->create();

        $this->actingAs($user1)
            ->getJson(route('watchlist.index', $user2->id))
            ->assertRedirect('/');
    }

    /** @test */
    public function guest_cannot_see_watchlist_index_view()
    {
        $user = User::factory()->create();

        $this->getJson(route('watchlist.index', $user->id))
            ->assertStatus(401); //unauthorised
    }

    /** @test */
    public function user_can_see_their_own_watchlist_create_view()
    {
        $user = User::factory()->create([
            'is_admin' => false
        ]);

        $this->actingAs($user)
            ->getJson(route('watchlist.create', $user->id))
            ->assertRedirect();
    }

    /** @test */
    public function admin_cannot_see_others_watchlist_create_view()
    {
        $admin = User::factory()->admin()->create();
        $user = User::factory()->create();

        $this->actingAs($admin)
            ->getJson(route('watchlist.create', $user->id))
            ->assertRedirect('/');
    }

    /** @test */
    public function user_cannot_see_others_watchlist_create_view()
    {
        $user1 = User::factory()->create([
            'is_admin' => false
        ]);
        $user2 = User::factory()->create();

        $this->actingAs($user1)
            ->getJson(route('watchlist.create', $user2->id))
            ->assertRedirect('/');
    }

    /** @test */
    public function guest_cannot_see_watchlist_create_view()
    {
        $user = User::factory()->create();

        $this->getJson(route('watchlist.create', $user->id))
            ->assertStatus(401); //unauthorised
    }

    /** @test */
    public function user_can_add_a_movie_to_their_own_watchlist()
    {
        $user = User::factory()->create([
            'is_admin' => false
        ]);
        $movie = Movie::factory()->create();

        $this->actingAs($user)
            ->postJson(route('watchlist.store', $user->id), [
                'movie_id' => $movie->id,
                'user_id' => $user->id
            ])->assertRedirect();

        $this->assertDatabaseHas('movie_user', [
            'movie_id' => $movie->id,
            'user_id' => $user->id
        ]);
    }

    /** @test */
    public function user_cannot_add_a_movie_to_their_own_watchlist_if_it_already_exists_there()
    {
        $user = User::factory()->create([
            'is_admin' => false
        ]);
        $movie = Movie::factory()->create();
        $watchlist = MovieUser::factory()->create([
            'movie_id' => $movie->id,
            'user_id' => $user->id
        ]);

        $this->actingAs($user)
            ->postJson(route('watchlist.store', $watchlist->user_id), [
                'movie_id' => $watchlist->movie_id,
                'user_id' => $watchlist->user_id
            ])->assertRedirect("profile/$watchlist->user_id/watchlist");
    }

    /** @test */
    public function admin_cannot_add_a_movie_to_others_watchlist()
    {
        $admin = User::factory()->create([
            'is_admin' => false
        ]);
        $user  = User::factory()->create();
        $movie = Movie::factory()->create();

        $this->actingAs($admin)
            ->postJson(route('watchlist.store', $user->id), [
                'movie_id' => $movie->id,
                'user_id'  => $user->id
            ])->assertRedirect('/');

        $this->assertDatabaseMissing('movie_user', [
            'movie_id' => $movie->id,
            'user_id'  => $user->id
        ]);
    }

    /** @test */
    public function user_cannot_add_a_movie_to_others_watchlist()
    {
        $user1 = User::factory()->create([
            'is_admin' => false
        ]);
        $user2 = User::factory()->create();
        $movie = Movie::factory()->create();

        $this->actingAs($user1)
            ->postJson(route('watchlist.store', $user2->id), [
                'movie_id' => $movie->id,
                'user_id' => $user2->id
            ])->assertRedirect('/');

        $this->assertDatabaseMissing('movie_user', [
            'movie_id' => $movie->id,
            'user_id' => $user2->id
        ]);
    }

    /** @test */
    public function guest_cannot_add_a_movie_to_watchlist()
    {
        $user = User::factory()->create();
        $movie = Movie::factory()->create();

        $this->postJson(route('watchlist.store', $user->id), [
                'movie_id' => $movie->id,
                'user_id' => $user->id
            ])->assertStatus(401); //unauthorised

        $this->assertDatabaseMissing('movie_user', [
            'movie_id' => $movie->id,
            'user_id' => $user->id
        ]);
    }

    /** @test */
    public function user_can_remove_a_movie_from_their_own_watchlist()
    {
        $user = User::factory()->create([
            'is_admin' => false
        ]);
        $movie = Movie::factory()->create();

        $watchlist = MovieUser::factory()->create([
            'movie_id' => $movie->id,
            'user_id' => $user->id
        ]);

        $this->assertDatabaseHas('movie_user', [
            'movie_id' => $watchlist->movie_id,
            'user_id' => $watchlist->user_id
        ]);

        $this->actingAs($user)
            ->deleteJson(route('watchlist.destroy', ['user' => $watchlist->user_id, 'movie' => $watchlist->movie_id]))
            ->assertRedirect();

        $this->assertDatabaseMissing('movie_user', [
            'movie_id' => $watchlist->movie_id,
            'user_id' => $watchlist->user_id
        ]);
    }

    /** @test */
    public function admin_cannot_remove_a_movie_from_others_watchlist()
    {
        $admin = User::factory()->admin()->create();
        $user = User::factory()->create();
        $movie = Movie::factory()->create();

        $watchlist = MovieUser::factory()->create([
            'movie_id' => $movie->id,
            'user_id' => $user->id
        ]);

        $this->actingAs($admin)
            ->deleteJson(route('watchlist.destroy', ['user' => $watchlist->user_id, 'movie' => $watchlist->movie_id]))
            ->assertRedirect('/');

        $this->assertDatabaseHas('movie_user', [
            'movie_id' => $watchlist->movie_id,
            'user_id' => $watchlist->user_id
        ]);
    }

    /** @test */
    public function user_cannot_remove_a_movie_from_others_watchlist()
    {
        $user1 = User::factory()->create([
            'is_admin' => false
        ]);
        $user2 = User::factory()->create();
        $movie = Movie::factory()->create();

        $watchlist = MovieUser::factory()->create([
            'movie_id' => $movie->id,
            'user_id' => $user2->id
        ]);

        $this->actingAs($user1)
            ->deleteJson(route('watchlist.destroy', ['user' => $watchlist->user_id, 'movie' => $watchlist->movie_id]))
            ->assertRedirect('/');

        $this->assertDatabaseHas('movie_user', [
            'movie_id' => $watchlist->movie_id,
            'user_id' => $watchlist->user_id
        ]);
    }

    /** @test */
    public function guest_cannot_remove_a_movie_from_watchlist()
    {
        $user = User::factory()->create();
        $movie = Movie::factory()->create();

        $watchlist = MovieUser::factory()->create([
            'movie_id' => $movie->id,
            'user_id' => $user->id
        ]);

        $this->deleteJson(route('watchlist.destroy', ['user' => $watchlist->user_id, 'movie' => $watchlist->movie_id]))
            ->assertStatus(401); //unauthorised

        $this->assertDatabaseHas('movie_user', [
            'movie_id' => $watchlist->movie_id,
            'user_id' => $watchlist->user_id
        ]);
    }
}
