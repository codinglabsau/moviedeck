<?php

namespace Tests\Http;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CelebTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function admin_can_see_celebs_create_view()
    {
        $admin = \App\Models\User::factory()->admin()->create();

        $this->actingAs($admin)
            ->getJson('celebs/create')
            ->assertOk();
    }

    /** @test */
    public function user_cannot_see_celebs_create_view()
    {
        $user = \App\Models\User::factory()->create([
            'is_admin' => false
        ]);

        $this->actingAs($user)
             ->getJson('celebs/create')
             ->assertRedirect();
    }

    /** @test */
    public function guest_cannot_see_celebs_create_view()
    {
        $this->getJson('celebs/create')
             ->assertRedirect();
    }

    /** @test */
    public function admin_can_create_a_new_celeb()
    {
        $admin = \App\Models\User::factory()->admin()->create();

        $this->actingAs($admin)
            ->postJson('celebs', [
                'name' => 'John Farnaby',
                'date_of_birth' => '05/06/1988',
                'photo' => 'https://generic/photo 700x600'
            ])->assertSessionHasNoErrors();

        $this->assertDatabaseHas('celebs', [
            'name' => 'John Farnaby',
            'date_of_birth' => '05/06/1988',
            'photo' => 'https://generic/photo 700x600'
        ]);
    }

    /** @test */
    public function validation_produces_errors_when_admin_stores_celeb_with_one_invalid_data()
    {
        $admin = \App\Models\User::factory()->admin()->create();

        $this->actingAs($admin)
            ->post('celebs', [
                'name' => 'James Weatherby',
                'date_of_birth' => '14/05/1996',
                'photo' => null
            ])->assertSessionHasErrors(['photo']);
    }

    /** @test */
    public function validation_produces_errors_when_admin_stores_celeb_with_all_invalid_data()
    {
        $admin = \App\Models\User::factory()->admin()->create();

        $this->actingAs($admin)
            ->post('celebs', [
                'name' => null,
                'date_of_birth' => null,
                'photo' => null
            ])->assertSessionHasErrors(['name', 'date_of_birth', 'photo']);
    }

    /** @test */
    public function user_cannot_create_a_celeb()
    {
        $user = \App\Models\User::factory()->create([
            'is_admin' => false
        ]);

        $this->actingAs($user)
            ->postJson('celebs')
            ->assertRedirect();
    }

    /** @test */
    public function guest_cannot_create_a_celeb()
    {
        $this->postJson('celebs')
            ->assertRedirect();
    }

    /** @test */
    public function admin_can_see_celebs_edit_view()
    {
        $celeb = \App\Models\Celeb::factory()->create();
        $admin = \App\Models\User::factory()->admin()->create();

        $this->actingAs($admin)
            ->getJson("celebs/$celeb->id/edit")
            ->assertOk();
    }

    /** @test */
    public function user_cannot_see_celebs_edit_view()
    {
        $celeb = \App\Models\Celeb::factory()->create();
        $user = \App\Models\User::factory()->create([
            'is_admin' => false
        ]);

        $this->actingAs($user)
            ->getJson("celebs/$celeb->id/edit")
            ->assertRedirect();
    }

    /** @test */
    public function guest_cannot_see_celebs_edit_view()
    {
        $celeb = \App\Models\Celeb::factory()->create();
        $this->getJson("celebs/$celeb->id/edit")
            ->assertRedirect();
    }

    /** @test */
    public function admin_can_update_a_celeb()
    {
        $celeb = \App\Models\Celeb::factory()->create();
        $admin = \App\Models\User::factory()->admin()->create();

        $this->actingAs($admin)
            ->putJson("celebs/$celeb->id", [
                'name' => 'Jennifer Jaxon',
                'date_of_birth' => '27/11/1982',
                'photo' => 'https://generic/photo1 700x600'
            ])->assertSessionHasNoErrors();

        $this->assertDatabaseHas('celebs', [
            'name' => 'Jennifer Jaxon',
            'date_of_birth' => '27/11/1982',
            'photo' => 'https://generic/photo1 700x600'
        ]);
    }

    /** @test */
    public function validation_produces_errors_when_admin_updates_celeb_with_one_invalid_data()
    {
        $celeb = \App\Models\Celeb::factory()->create();
        $admin = \App\Models\User::factory()->admin()->create();

        $this->actingAs($admin)
            ->put("celebs/$celeb->id", [
                'name' => 'Olivia Plankton',
                'date_of_birth' => '08/04/1994',
                'photo' => null
            ])->assertSessionHasErrors(['photo']);
    }

    /** @test */
    public function validation_produces_errors_when_admin_updates_celeb_with_all_invalid_data()
    {
        $celeb = \App\Models\Celeb::factory()->create();
        $admin = \App\Models\User::factory()->admin()->create();

        $this->actingAs($admin)
            ->put("celebs/$celeb->id", [
                'name' => null,
                'date_of_birth' => null,
                'photo' => null
            ])->assertSessionHasErrors(['name', 'date_of_birth', 'photo']);
    }

    /** @test */
    public function user_cannot_update_celeb()
    {
        $celeb = \App\Models\Celeb::factory()->create();
        $user = \App\Models\User::factory()->create([
            'is_admin' => false
        ]);

        $this->actingAs($user)
            ->putJson("celebs/$celeb->id")
            ->assertRedirect();
    }

    /** @test */
    public function guest_cannot_update_a_celeb()
    {
        $celeb = \App\Models\Celeb::factory()->create();
        $this->putJson("celebs/$celeb->id")
            ->assertRedirect();
    }

    /** @test */
    public function admin_can_delete_a_celeb()
    {
        $admin = \App\Models\User::factory()->admin()->create();
        $celeb = \App\Models\Celeb::factory()->create();

        $this->actingAs($admin)
             ->deleteJson("celebs/$celeb->id")
             ->assertStatus(302);

        $this->assertDatabaseMissing('celebs', [
            'id' => $celeb->id,
        ]);
    }

    /** @test */
    public function user_cannot_delete_a_celeb()
    {
        $celeb = \App\Models\Celeb::factory()->create();
        $user = \App\Models\User::factory()->create([
            'is_admin' => false
        ]);

        $this->actingAs($user)
            ->deleteJson("celebs/$celeb->id")
            ->assertRedirect();
    }

    /** @test */
    public function guest_cannot_delete_a_celeb()
    {
        $celeb = \App\Models\Celeb::factory()->create();
        $this->deleteJson("celebs/$celeb->id")
            ->assertRedirect();
    }
}
