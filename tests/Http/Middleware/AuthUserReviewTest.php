<?php

namespace Tests\Http\Middleware;

use Tests\TestCase;
use App\Models\User;
use App\Models\Movie;
use App\Models\Review;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AuthUserReviewTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function an_auth_user_can_see_reviews_view()
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->getJson('/reviews')
            ->assertOk();
    }

    /** @test */
    public function a_guest_can_see_reviews_view()
    {
        $this->getJson('/reviews')
            ->assertOk();
    }

    /** @test */
    public function any_auth_user_can_see_create_reviews_view()
    {
        $movie = Movie::factory()->create();
        $user = User::factory()->create();

        $this->actingAs($user)
            ->getJson("/reviews/create/$movie->id")
            ->assertOk();
    }

    /** @test */
    public function a_guest_cannot_access_create_reviews_view()
    {
        $movie = Movie::factory()->create();

        $this->getJson("/reviews/create/$movie->id")
            ->assertUnauthorized();
    }

    /** @test */
    public function a_user_can_access_edit_view_of_their_review()
    {
        $user = User::factory()->create();
        $movie = Movie::factory()->create();
        $review = Review::factory()->create([
            'user_id' => $user->id,
            'movie_id' => $movie->id,
            'title' => 'Review Title Sample',
            'rating' => 4.8,
            'content' => 'Sample review content',
        ]);

        $this->actingAs($user)
            ->get("/reviews/{$review->id}/edit")
            ->assertOk();
    }

    /** @test */
    public function a_user_cannot_access_edit_view_of_a_review_they_did_not_create()
    {
        $user = User::factory()->create([
            'id' => 1
        ]);
        $movie = Movie::factory()->create();
        $review = Review::factory()->create([
            'user_id' => $user->id,
            'movie_id' => $movie->id,
            'title' => 'Review Title Sample',
            'rating' => 4.8,
            'content' => 'Sample review content',
        ]);

        $anotherUser = User::factory()->create([
            'id' => 2
        ]);

        $this->actingAs($anotherUser)
            ->get("/reviews/{$review->id}/edit")
            ->assertRedirect()
            ->assertSessionHas('status');
    }

    /** @test */
    public function a_guest_cannot_see_edit_review_view()
    {
        $user = User::factory()->create();
        $movie = Movie::factory()->create();
        $review = Review::factory()->create([
            'user_id' => $user->id,
            'movie_id' => $movie->id,
            'title' => 'Review Title Sample',
            'rating' => 4.8,
            'content' => 'Sample review content',
        ]);

        $this->get("/reviews/{$review->id}/edit")
            ->assertRedirect();
    }
}
