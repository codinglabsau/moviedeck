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
        $celeb1 = Celeb::factory()->create([
            'name' => 'Jen Generic'
        ]);
        $celeb2 = Celeb::factory()->create([
            'name' => 'James Generic'
        ]);

        $this->getJson('/search?type=movies&&search=Generic')
            ->assertJsonCount(2)
            ->assertJsonFragment(['id'=> $movie1->id])
            ->assertJsonFragment(['id'=> $movie2->id]);
    }
}
