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
    public function an_admin_can_add_a_review()
    {
        $admin = User::factory()->admin()->create();
        $movie = Movie::factory()->create();

        $this->actingAs($admin)
            ->postJson('/reviews', [
                'user_id' => $admin->id,
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
            'user_id' => $admin->id,
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
    public function a_user_can_add_a_review()
    {
        $movie = Movie::factory()->create();
        $user = User::factory()->create([
            'is_admin' => false
        ]);

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

    /** @test */
    public function a_user_can_delete_a_review()
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
}
