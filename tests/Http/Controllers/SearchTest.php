<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Movie;
use App\Models\Celeb;
use Tests\TestCase;

class SearchTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function when_movies_is_selected_only_searches_through_movies_table()
    {
        $movie1 = Movie::factory()->create([
            'title' => 'Generic Movie1'
        ]);

        $movie2 = Movie::factory()->create([
            'title' => 'Generic Movie2'
        ]);

        $celeb = Celeb::factory()->create([
            'name' => 'Jen Generic'
        ]);

        $response = $this->getJson('/search?type=movies&&search=Generic')
            ->assertOk()
            ->assertViewHas('results')
            ->assertSee($movie1->title)
            ->assertSee($movie2->title)
            ->assertDontsee($celeb->name);

        $this->assertCount(2, $response->original['results']);
    }

    /** @test */
    public function when_celebs_is_selected_only_searches_through_celebs_table()
    {
        $movie1 = Movie::factory()->create([
            'title' => 'Generic Movie1'
        ]);

        $movie2 = Movie::factory()->create([
            'title' => 'Generic Movie2'
        ]);

        $celeb = Celeb::factory()->create([
            'name' => 'Jen Generic'
        ]);

        $response = $this->getJson('/search?type=celebs&&search=Generic')
            ->assertOk()
            ->assertViewHas('results')
            ->assertSee($celeb->name)
            ->assertDontsee($movie1->title)
            ->assertDontsee($movie2->title);

        $this->assertCount(1, $response->original['results']);

    }

    /** @test */
    public function when_movies_is_selected_search_filters_results_properly()
    {
        $movie1 = Movie::factory()->create([
            'title' => 'Generic Movie'
        ]);

        $movie2 = Movie::factory()->create([
            'title' => 'Different Movie'
        ]);

        $celeb = Celeb::factory()->create([
            'name' => 'Jen Generic'
        ]);

        $response = $this->getJson('/search?type=movies&&search=Generic')
            ->assertOk()
            ->assertViewHas('results')
            ->assertSee($movie1->title)
            ->assertDontsee($movie2->title)
            ->assertDontsee($celeb->name);

        $this->assertCount(1, $response->original['results']);
    }

    /** @test */
    public function when_celebs_is_selected_search_filters_results_properly()
    {
        $movie = Movie::factory()->create([
            'title' => 'Generic Movie'
        ]);

        $celeb1 = Celeb::factory()->create([
            'name' => 'Jen Generic'
        ]);

        $celeb2 = Celeb::factory()->create([
            'name' => 'James Simple'
        ]);

        $response = $this->getJson('/search?type=celebs&&search=Generic')
            ->assertOk()
            ->assertViewHas('results')
            ->assertSee($celeb1->name)
            ->assertDontsee($movie->title)
            ->assertDontsee($celeb2->name);

        $this->assertCount(1, $response->original['results']);
    }
}
