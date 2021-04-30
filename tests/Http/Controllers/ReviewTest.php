<?php

namespace Tests\Http\Controllers;

use Tests\TestCase;
use App\Models\User;
use App\Models\Movie;
use App\Models\Review;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ReviewTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function an_auth_user_can_access_reviews_view()
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->getJson('/reviews')
            ->assertOk();
    }

    /** @test */
    public function a_guest_can_access_reviews_view()
    {
        $this->getJson('/reviews')
            ->assertOk();
    }

    /** @test */
    public function any_auth_user_can_access_create_reviews_view()
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
    public function a_guest_cannot_access_edit_review_view()
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
    public function any_auth_user_can_add_a_review()
    {
        $movie = Movie::factory()->create();
        $user = User::factory()->create();

        $this->actingAs($user)
            ->postJson('/reviews', [
                'user_id' => $user->id,
                'movie_id' => $movie->id,
                'title' => 'Mock Turtle, suddenly.',
                'rating' => 4.8,
                'content' =>
                    'Officia perspiciatis est quam aperiam. Dolor voluptatibus nemo vel molestiae quia aut. Dolor reprehenderit autem dolor eaque.
                Molestiae blanditiis veniam quis iure officiis explicabo. Rerum veniam et nam voluptatem itaque quaerat omnis.
                Necessitatibus voluptatem odit eaque repudiandae voluptatem qui. Ea et alias maiores sint aliquam qui veniam eaque.
                Saepe occaecati id aut doloremque repellat. Maiores neque deserunt dolores numquam quia ab quam.'
            ])
            ->assertRedirect('/reviews')
            ->assertSessionHas('status');

        $this->assertDatabaseHas('reviews', [
            'user_id' => $user->id,
            'movie_id' => $movie->id,
            'title' => 'Mock Turtle, suddenly.',
            'rating' => 4.8,
            'content' =>
                'Officia perspiciatis est quam aperiam. Dolor voluptatibus nemo vel molestiae quia aut. Dolor reprehenderit autem dolor eaque.
                Molestiae blanditiis veniam quis iure officiis explicabo. Rerum veniam et nam voluptatem itaque quaerat omnis.
                Necessitatibus voluptatem odit eaque repudiandae voluptatem qui. Ea et alias maiores sint aliquam qui veniam eaque.
                Saepe occaecati id aut doloremque repellat. Maiores neque deserunt dolores numquam quia ab quam.'
        ]);
    }

    /** @test */
    public function a_guest_cannot_add_a_review()
    {
        $user = User::factory()->create();
        $movie = Movie::factory()->create();

        $this->postJson('/reviews', [
                'user_id' => $user->id,
                'movie_id' => $movie->id,
                'title' => 'Mock Turtle, suddenly.',
                'rating' => 4.8,
                'content' =>
                    'Officia perspiciatis est quam aperiam. Dolor voluptatibus nemo vel molestiae quia aut. Dolor reprehenderit autem dolor eaque.
                Molestiae blanditiis veniam quis iure officiis explicabo. Rerum veniam et nam voluptatem itaque quaerat omnis.
                Necessitatibus voluptatem odit eaque repudiandae voluptatem qui. Ea et alias maiores sint aliquam qui veniam eaque.
                Saepe occaecati id aut doloremque repellat. Maiores neque deserunt dolores numquam quia ab quam.'
            ])->assertUnauthorized();

        $this->assertDatabaseMissing('reviews', [
            'user_id' => $user->id,
            'movie_id' => $movie->id,
            'title' => 'Mock Turtle, suddenly.',
            'rating' => 4.8,
            'content' =>
                'Officia perspiciatis est quam aperiam. Dolor voluptatibus nemo vel molestiae quia aut. Dolor reprehenderit autem dolor eaque.
                Molestiae blanditiis veniam quis iure officiis explicabo. Rerum veniam et nam voluptatem itaque quaerat omnis.
                Necessitatibus voluptatem odit eaque repudiandae voluptatem qui. Ea et alias maiores sint aliquam qui veniam eaque.
                Saepe occaecati id aut doloremque repellat. Maiores neque deserunt dolores numquam quia ab quam.'
        ]);
    }

    /** @test */
    public function a_user_can_update_their_review()
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
                'title' => 'Mock Turtle, suddenly.',
                'rating' => 4.8,
                'content' =>
                    'Officia perspiciatis est quam aperiam. Dolor voluptatibus nemo vel molestiae quia aut. Dolor reprehenderit autem dolor eaque.
                Molestiae blanditiis veniam quis iure officiis explicabo. Rerum veniam et nam voluptatem itaque quaerat omnis.
                Necessitatibus voluptatem odit eaque repudiandae voluptatem qui. Ea et alias maiores sint aliquam qui veniam eaque.
                Saepe occaecati id aut doloremque repellat. Maiores neque deserunt dolores numquam quia ab quam.'
            ])
            ->assertRedirect("/reviews/{$review->id}")
            ->assertSessionHas('status');

        $this->assertDatabaseHas('reviews', [
            'id' => $review->id,
            'user_id' => $user->id,
            'movie_id' => $movie->id,
            'title' => 'Mock Turtle, suddenly.',
            'rating' => 4.8,
            'content' =>
                'Officia perspiciatis est quam aperiam. Dolor voluptatibus nemo vel molestiae quia aut. Dolor reprehenderit autem dolor eaque.
                Molestiae blanditiis veniam quis iure officiis explicabo. Rerum veniam et nam voluptatem itaque quaerat omnis.
                Necessitatibus voluptatem odit eaque repudiandae voluptatem qui. Ea et alias maiores sint aliquam qui veniam eaque.
                Saepe occaecati id aut doloremque repellat. Maiores neque deserunt dolores numquam quia ab quam.'
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
            'title' => 'Mock Turtle, suddenly.',
            'rating' => 4.8,
            'content' =>
                'Officia perspiciatis est quam aperiam. Dolor voluptatibus nemo vel molestiae quia aut. Dolor reprehenderit autem dolor eaque.
                Molestiae blanditiis veniam quis iure officiis explicabo. Rerum veniam et nam voluptatem itaque quaerat omnis.
                Necessitatibus voluptatem odit eaque repudiandae voluptatem qui. Ea et alias maiores sint aliquam qui veniam eaque.
                Saepe occaecati id aut doloremque repellat. Maiores neque deserunt dolores numquam quia ab quam.'
        ]);

        $this->putJson("/reviews/{$review->id}", [
            'id' => $review->id,
            'user_id' => $user->id,
            'movie_id' => $movie->id,
            'title' => 'Alice waited till she was up.',
            'rating' => 4.8,
            'content' =>
                'Ullam veniam suscipit dolores reiciendis eius. Consequatur facilis vero quo vel. Possimus modi dicta voluptatem id doloremque omnis.
                Omnis consequuntur unde voluptatibus ipsum explicabo quis rerum. Asperiores aut aut aut ex pariatur.
                Nostrum qui amet et voluptatum fuga minus nemo est. Eligendi quo in quas eum amet dolore cumque eaque.'
        ])->assertUnauthorized();

        $this->assertDatabaseMissing('reviews', [
            'id' => $review->id,
            'user_id' => $user->id,
            'movie_id' => $movie->id,
            'title' => 'Alice waited till she was up.',
            'rating' => 4.8,
            'content' =>
                'Ullam veniam suscipit dolores reiciendis eius. Consequatur facilis vero quo vel. Possimus modi dicta voluptatem id doloremque omnis.
                Omnis consequuntur unde voluptatibus ipsum explicabo quis rerum. Asperiores aut aut aut ex pariatur.
                Nostrum qui amet et voluptatum fuga minus nemo est. Eligendi quo in quas eum amet dolore cumque eaque.'
        ]);
    }

    /** @test */
    public function a_user_can_delete_the_review_they_created()
    {
        $user = User::factory()->create();
        $movie = Movie::factory()->create();
        $review = Review::factory()->create([
            'user_id' => $user->id,
            'movie_id' => $movie->id,
            'title' => 'Mock Turtle, suddenly.',
            'rating' => 4.8,
            'content' =>
                'Officia perspiciatis est quam aperiam. Dolor voluptatibus nemo vel molestiae quia aut. Dolor reprehenderit autem dolor eaque.
                Molestiae blanditiis veniam quis iure officiis explicabo. Rerum veniam et nam voluptatem itaque quaerat omnis.
                Necessitatibus voluptatem odit eaque repudiandae voluptatem qui. Ea et alias maiores sint aliquam qui veniam eaque.
                Saepe occaecati id aut doloremque repellat. Maiores neque deserunt dolores numquam quia ab quam.'
        ]);

        $this->actingAs($user)
            ->delete("/reviews/{$review->id}")
            ->assertRedirect('/reviews')
            ->assertSessionHas('status');

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
            'title' => 'Mock Turtle, suddenly.',
            'rating' => 4.8,
            'content' =>
                'Officia perspiciatis est quam aperiam. Dolor voluptatibus nemo vel molestiae quia aut. Dolor reprehenderit autem dolor eaque.
                Molestiae blanditiis veniam quis iure officiis explicabo. Rerum veniam et nam voluptatem itaque quaerat omnis.
                Necessitatibus voluptatem odit eaque repudiandae voluptatem qui. Ea et alias maiores sint aliquam qui veniam eaque.
                Saepe occaecati id aut doloremque repellat. Maiores neque deserunt dolores numquam quia ab quam.'
        ]);

        $this->delete("/reviews/{$review->id}")
            ->assertRedirect();

        $this->assertDatabaseHas('reviews', [
            'id' => $review->id,
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
            'title' => 'Mock Turtle, suddenly.',
            'rating' => 4.8,
            'content' =>
                'Officia perspiciatis est quam aperiam. Dolor voluptatibus nemo vel molestiae quia aut. Dolor reprehenderit autem dolor eaque.
                Molestiae blanditiis veniam quis iure officiis explicabo. Rerum veniam et nam voluptatem itaque quaerat omnis.
                Necessitatibus voluptatem odit eaque repudiandae voluptatem qui. Ea et alias maiores sint aliquam qui veniam eaque.
                Saepe occaecati id aut doloremque repellat. Maiores neque deserunt dolores numquam quia ab quam.'
        ]);
        $admin = User::factory()->admin()->create();

        $this->actingAs($admin)
            ->delete("/reviews/{$review->id}")
            ->assertRedirect('/reviews')
            ->assertSessionHas('status');

        $this->assertDatabaseMissing('reviews', [
            'id' => $review->id,
        ]);
    }
}
