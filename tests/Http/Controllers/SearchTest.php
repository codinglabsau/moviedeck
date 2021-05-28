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
        Movie::factory()->create([
            'title' => 'Generic Movie1'
        ]);

        Movie::factory()->create([
            'title' => 'Generic Movie2'
        ]);

        Celeb::factory()->create([
            'name' => 'Jen Generic'
        ]);


        $response = $this->getJson('/search?type=movies&&search=Generic')
            ->assertOk()
            ->assertViewHas('results');

        $this->assertEquals(2, count($response->original['results']));
    }

    /** @test */
    public function when_celebs_is_selected_only_searches_through_celebs_table()
    {
        Movie::factory()->create([
            'title' => 'Generic Movie1'
        ]);

        Movie::factory()->create([
            'title' => 'Generic Movie2'
        ]);

        Celeb::factory()->create([
            'name' => 'Jen Generic'
        ]);

        $response = $this->getJson('/search?type=celebs&&search=Generic')
            ->assertOk()
            ->assertViewHas('results');

        $this->assertEquals(1, count($response->original['results']));
    }

    /** @test */
    public function when_movies_is_selected_search_filters_results_properly()
    {
        Movie::factory()->create([
            'title' => 'Generic Movie'
        ]);

        Movie::factory()->create([
            'title' => 'Different Movie'
        ]);

        Celeb::factory()->create([
            'name' => 'Jen Generic'
        ]);

        $response = $this->getJson('/search?type=movies&&search=Generic')
            ->assertOk()
            ->assertViewHas('results');

        $this->assertEquals(1, count($response->original['results']));
    }

    /** @test */
    public function when_celebs_is_selected_search_filters_results_properly()
    {
        Movie::factory()->create([
            'title' => 'Generic Movie'
        ]);

        Celeb::factory()->create([
            'name' => 'Jen Generic'
        ]);

        Celeb::factory()->create([
            'name' => 'James Simple'
        ]);

        $response = $this->getJson('/search?type=celebs&&search=Generic')
            ->assertOk()
            ->assertViewHas('results');

        $this->assertEquals(1, count($response->original['results']));
    }
}
