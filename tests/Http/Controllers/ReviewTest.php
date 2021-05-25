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
            ->getJson("/movies/{$movie->id}/reviews/create")
            ->assertOk();
    }

    /** @test */
    public function a_guest_cannot_access_create_reviews_view()
    {
        $movie = Movie::factory()->create();

        $this->getJson("/movies/{$movie->id}/reviews/create")
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
            ->get("/movies/{$movie->id}/reviews/{$review->id}/edit")
            ->assertOk();
    }

    /** @test */
    public function a_user_cannot_access_edit_view_of_a_review_they_did_not_create()
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

        $anotherUser = User::factory()->create();

        $this->actingAs($anotherUser)
            ->get("/movies/{$movie->id}/reviews/{$review->id}/edit")
            ->assertRedirect("/movies/{$movie->id}/reviews/{$review->id}")
            ->assertSessionHas('message', 'Oops! You do not have permission to edit this review.');
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

        $this->get("/movies/{$movie->id}/reviews/{$review->id}/edit")
            ->assertRedirect('/login');
    }

    /** @test */
    public function any_auth_user_can_add_a_review()
    {
        $movie = Movie::factory()->create();
        $user = User::factory()->create();

        $this->actingAs($user)
            ->postJson("/movies/{$movie->id}/reviews", [
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
            ->assertSessionHas('message', 'Success! Review has been added.');

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

        $this->postJson("/movies/{$movie->id}/reviews", [
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
            ->putJson("/movies/{$movie->id}/reviews/{$review->id}", [
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
            ->assertRedirect("/movies/{$movie->id}/reviews/{$review->id}")
            ->assertSessionHas('message', 'Success! Review has been updated.');

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
    public function any_auth_user_cannot_edit_a_review_they_did_not_create()
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

        $anotherUser = User::factory()->create();

        $this->actingAs($anotherUser)
            ->putJson("/movies/{$movie->id}/reviews/{$review->id}", [
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
            ->assertForbidden();

        $this->assertDatabaseMissing('reviews', [
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

        $this->putJson("/movies/{$movie->id}/reviews/{$review->id}", [
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
    public function a_user_can_delete_a_review_they_created()
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
            ->delete("/movies/{$movie->id}/reviews/{$review->id}")
            ->assertRedirect('/reviews')
            ->assertSessionHas('message', 'Success! Review has been deleted.');

        $this->assertDatabaseMissing('reviews', [
            'id' => $review->id,
        ]);
    }

    /** @test */
    public function any_auth_user_cannot_delete_a_review_they_did_not_create()
    {
        $user = User::factory()->create([
            'is_admin' => false
        ]);
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

        $anotherUser = User::factory()->create([
            'is_admin' => false
        ]);

        $this->actingAs($anotherUser)
            ->delete("/movies/{$movie->id}/reviews/{$review->id}")
            ->assertRedirect("/movies/{$movie->id}/reviews/{$review->id}")
            ->assertSessionHas('message', 'Oops! You do not have permission to delete this review.');

        $this->assertDatabaseHas('reviews', [
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

        $this->delete("/movies/{$movie->id}/reviews/{$review->id}")
            ->assertRedirect('/login');

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
            ->delete("/movies/{$movie->id}/reviews/{$review->id}")
            ->assertRedirect('/reviews')
            ->assertSessionHas('message', 'Success! Review has been deleted.');

        $this->assertDatabaseMissing('reviews', [
            'id' => $review->id,
        ]);
    }
}
