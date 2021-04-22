<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Movie;
use App\Models\Review;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ReviewTest extends TestCase
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
        $this->withoutExceptionHandling();

        $admin = User::factory()->admin()->create();

        $this->actingAs($admin)
            ->getJson('/reviews/create')
            ->assertOk();
    }

    /** @test */
    public function a_user_can_see_create_reviews_view()
    {
        $user = User::factory()->create([
            'is_admin' => false
        ]);

        $this->actingAs($user)
            ->getJson('/reviews/create')
            ->assertOk();
    }

    /** @test */
    public function a_guest_cannot_see_create_reviews_view()
    {
        $this->getJson('/reviews/create')
            ->assertUnauthorized();
    }

    /** @test */
    public function an_admin_can_add_a_review()
    {
        $this->withoutExceptionHandling();
        $admin = User::factory()->admin()->create();

        $this->actingAs($admin)
            ->postJson('/reviews', [
                'user_id' => 1,
                'movie_id' => 1,
                'title' => 'Review Title Sample',
                'rating' => 4.8,
                'content' => 'Sample review content',
            ])->assertOk();

        $this->assertDatabaseHas('reviews', [
            'user_id' => 1,
            'movie_id' => 1,
            'title' => 'Review Title Sample',
            'rating' => 4.8,
            'content' => 'Sample review content',
        ]);
    }

    /** @test */
    public function a_user_can_add_a_review()
    {
        $user = User::factory()->create([
            'is_admin' => false
        ]);

        $this->actingAs($user)
            ->postJson('/reviews', [
                'user_id' => 1,
                'movie_id' => 1,
                'title' => 'Review Title Sample',
                'rating' => 4.8,
                'content' => 'Sample review content',
            ])->assertOk();

        $this->assertDatabaseHas('reviews', [
            'user_id' => 1,
            'movie_id' => 1,
            'title' => 'Review Title Sample',
            'rating' => 4.8,
            'content' => 'Sample review content',
        ]);
    }

    /** @test */
    public function a_guest_cannot_add_a_review()
    {
        $this->postJson('/reviews', [
            'user_id' => 1,
            'movie_id' => 1,
            'title' => 'Review Title Sample',
            'rating' => 4.8,
            'content' => 'Sample review content',
        ])->assertUnauthorized();

        $this->assertDatabaseMissing('reviews', [
            'user_id' => 1,
            'movie_id' => 1,
            'title' => 'Review Title Sample',
            'rating' => 4.8,
            'content' => 'Sample review content',
        ]);
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

    /** @test */
    public function an_admin_can_update_a_review()
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
            ->putJson("/reviews/{$review->id}", [
                'id' => $review->id,
                'user_id' => $user->id,
                'movie_id' => $movie->id,
                'title' => 'Review Updated Title Sample',
                'rating' => 3.6,
                'content' => 'Sample updated review content',
            ])->assertOk();

        $this->assertDatabaseHas('reviews', [
            'id' => $review->id,
            'user_id' => $user->id,
            'movie_id' => $movie->id,
            'title' => 'Review Updated Title Sample',
            'rating' => 3.6,
            'content' => 'Sample updated review content',
        ]);
    }

    /** @test */
    public function a_user_can_update_a_review()
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
            ->putJson("/reviews/{$review->id}", [
                'id' => $review->id,
                'user_id' => $user->id,
                'movie_id' => $movie->id,
                'title' => 'Review Updated Title Sample',
                'rating' => 3.6,
                'content' => 'Sample updated review content',
            ])->assertOk();

        $this->assertDatabaseHas('reviews', [
            'id' => $review->id,
            'user_id' => $user->id,
            'movie_id' => $movie->id,
            'title' => 'Review Updated Title Sample',
            'rating' => 3.6,
            'content' => 'Sample updated review content',
        ]);
    }

    /** @test */
    public function a_guest_cannot_update_a_review()
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

        $this->putJson("/reviews/{$review->id}", [
            'id' => $review->id,
            'user_id' => $user->id,
            'movie_id' => $movie->id,
            'title' => 'Review Updated Title Sample',
            'rating' => 3.6,
            'content' => 'Sample updated review content',
        ])->assertUnauthorized();

        $this->assertDatabaseMissing('reviews', [
            'id' => $review->id,
            'user_id' => $user->id,
            'movie_id' => $movie->id,
            'title' => 'Review Updated Title Sample',
            'rating' => 3.6,
            'content' => 'Sample updated review content',
        ]);
    }

    /** @test */
    public function an_admin_can_delete_a_review()
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
            ->delete("/reviews/{$review->id}")
            ->assertOk();

        $this->assertDatabaseMissing('reviews', [
            'id' => $review->id,
        ]);
    }

    /** @test */
    public function a_user_can_delete_a_review()
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
            ->delete("/reviews/{$review->id}")
            ->assertOk();

        $this->assertDatabaseMissing('reviews', [
            'id' => $review->id,
        ]);
    }

    /** @test */
    public function a_guest_cannot_delete_a_review()
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

        $this->delete("/reviews/{$review->id}")
            ->assertRedirect();

        $this->assertDatabaseHas('reviews', [
            'id' => $review->id,
        ]);
    }
}
