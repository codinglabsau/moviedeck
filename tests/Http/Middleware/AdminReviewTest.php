<?php

namespace Tests\Http\Middleware;

use Tests\TestCase;
use App\Models\User;
use App\Models\Movie;
use App\Models\Review;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AdminReviewTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function an_admin_can_see_reviews_view()
    {
        $admin = User::factory()->admin()->create();

        $this->actingAs($admin)
            ->getJson('/reviews')
            ->assertOk();
    }

    /** @test */
    public function a_user_can_see_reviews_view()
    {
        $user = User::factory()->create([
            'is_admin' => false
        ]);

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
    public function an_admin_can_see_create_reviews_view()
    {
        $movie = Movie::factory()->create();
        $admin = User::factory()->admin()->create();

        $this->actingAs($admin)
            ->getJson("/reviews/create/$movie->id")
            ->assertOk();
    }

    /** @test */
    public function a_user_can_see_create_reviews_view()
    {
        $movie = Movie::factory()->create();
        $user = User::factory()->create([
            'is_admin' => false
        ]);

        $this->actingAs($user)
            ->getJson("/reviews/create/$movie->id")
            ->assertOk();
    }

    /** @test */
    public function a_guest_cannot_see_create_reviews_view()
    {
        $movie = Movie::factory()->create();

        $this->getJson("/reviews/create/$movie->id")
            ->assertUnauthorized();
    }

    /** @test */
    public function an_admin_can_see_edit_review_view()
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
        $admin = User::factory()->admin()->create();

        $this->actingAs($admin)
            ->get("/reviews/{$review->id}/edit")
            ->assertOk();
    }

    /** @test */
    public function a_user_can_see_edit_review_view()
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
