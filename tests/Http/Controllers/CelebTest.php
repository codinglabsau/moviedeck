<?php

namespace Tests\Http\Controllers;

use Carbon\Carbon;
use Tests\TestCase;
use App\Models\User;
use App\Models\Celeb;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CelebTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        Carbon::setTestNow(now());
    }

    /** @test */
    public function admin_can_see_celebs_create_view()
    {
        $admin = User::factory()->admin()->create();

        $this->actingAs($admin)
            ->getJson('celebs/create')
            ->assertOk();
    }

    /** @test */
    public function user_cannot_see_celebs_create_view()
    {
        $user = User::factory()->create([
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
        $admin = User::factory()->admin()->create();

        $this->actingAs($admin)
            ->post('celebs', [
                'name' => 'John Farnaby',
                'date_of_birth' => Carbon::now()->subYears(30),
                'photo' => 'https://generic/photo_700x600'
            ])->assertStatus(302);

        $this->assertDatabaseHas('celebs', [
            'name' => 'John Farnaby',
            'date_of_birth' => Carbon::now()->subYears(30),
            'photo' => 'https://generic/photo_700x600'
        ]);
    }

    /** @test */
    public function validation_error_when_celeb_has_one_invalid_data()
    {
        $admin = User::factory()->admin()->create();

        $this->actingAs($admin)
            ->post('celebs', [
                'name' => 'James Weatherby',
                'date_of_birth' => Carbon::now()->subYears(30),
                'photo' => null
            ])->assertSessionHasErrors([
                'photo' => 'The photo field is required.'
            ]);
    }

    /** @test */
    public function validation_errors_when_celeb_has_all_invalid_data()
    {
        $admin = User::factory()->admin()->create();

        $this->actingAs($admin)
            ->post('celebs', [])
            ->assertSessionHasErrors([
                'name' => 'The name field is required.',
                'date_of_birth' => 'The date of birth field is required.',
                'photo' => 'The photo field is required.'
            ]);
    }

    /** @test */
    public function validation_error_when_celeb_date_of_birth_is_after_todays_date()
    {
        $admin= User::factory()->admin()->create();

        $this->actingAs($admin)
             ->post('celebs', [
                 'name' => 'William Invalid',
                 'date_of_birth' => Carbon::now()->addYears(5),
                 'photo' => 'https://genericPhoto2.com'
             ])->assertSessionHasErrors([
                 'date_of_birth' => 'The date of birth must be a date before today.'
            ]);
    }

    /** @test */
    public function validation_error_when_celeb_name_is_too_short()
    {
        $admin= User::factory()->admin()->create();

        $this->actingAs($admin)
            ->post('celebs', [
                'name' => 'J',
                'date_of_birth' => Carbon::now()->subYears(30),
                'photo' => 'https://genericPhoto2.com'
            ])->assertSessionHasErrors([
                'name' => 'The name must be between 2 and 30 characters.'
            ]);
    }

    /** @test */
    public function validation_error_when_celeb_name_is_too_long()
    {
        $admin= User::factory()->admin()->create();

        $this->actingAs($admin)
            ->post('celebs', [
                'name' => 'Ronald Gibons-Hacksonford-James III',
                'date_of_birth' => Carbon::now()->subYears(30),
                'photo' => 'https://genericPhoto2.com'
            ])->assertSessionHasErrors([
                'name' => 'The name must be between 2 and 30 characters.'
            ]);
    }

    /** @test */
    public function user_cannot_create_a_celeb()
    {
        $user = User::factory()->create([
            'is_admin' => false
        ]);

        $this->actingAs($user)
            ->postJson('celebs', [
                'name' => 'Josie Jets',
                'date_of_birth' => Carbon::now()->subYears(30),
                'photo' => 'https://genericPhotos.com'
            ])->assertRedirect();

        $this->assertDatabaseMissing('celebs', [
            'name' => 'Josie Jets',
            'date_of_birth' => Carbon::now()->subYears(30),
            'photo' => 'https://genericPhotos.com'
        ]);
    }

    /** @test */
    public function guest_cannot_create_a_celeb()
    {
        $this->postJson('celebs', [
            'name' => 'Joe Generic',
            'date_of_birth' => Carbon::now()->subYears(30),
            'photo' => 'https://genericPhotos.com'
        ])->assertRedirect();

        $this->assertDatabaseMissing('celebs', [
            'name' => 'Joe Generic',
            'date_of_birth' => Carbon::now()->subYears(30),
            'photo' => 'https://genericPhotos.com'
        ]);
    }

    /** @test */
    public function admin_can_see_celebs_edit_view()
    {
        $this->withoutExceptionHandling();
        $celeb = Celeb::factory()->create();
        $admin = User::factory()->admin()->create();

        $this->actingAs($admin)
            ->getJson("celebs/$celeb->id/edit")
            ->assertOk();
    }

    /** @test */
    public function user_cannot_see_celebs_edit_view()
    {
        $celeb = Celeb::factory()->create();
        $user = User::factory()->create([
            'is_admin' => false
        ]);

        $this->actingAs($user)
            ->getJson("celebs/$celeb->id/edit")
            ->assertRedirect();
    }

    /** @test */
    public function guest_cannot_see_celebs_edit_view()
    {
        $celeb = Celeb::factory()->create();
        $this->getJson("celebs/$celeb->id/edit")
            ->assertRedirect();
    }

    /** @test */
    public function admin_can_update_a_celeb()
    {
        $celeb = Celeb::factory()->create([
            'name' => 'Jennifer Fallinbury',
            'date_of_birth' => Carbon::now()->subYears(30),
            'photo' => 'https://generic/photo1_700x600'
        ]);
        $admin = User::factory()->admin()->create();

        $this->actingAs($admin)
            ->put("celebs/$celeb->id", [
                'name' => 'Jennifer Jaxon',
                'date_of_birth' => Carbon::now()->subYears(30),
                'photo' => 'https://generic/photo1_700x600'
            ])->assertStatus(302);

        $this->assertDatabaseHas('celebs', [
            'id' => $celeb->id,
            'name' => 'Jennifer Jaxon',
            'date_of_birth' => Carbon::now()->subYears(30),
            'photo' => 'https://generic/photo1_700x600'
        ]);
    }

    /** @test */
    public function user_cannot_update_celeb()
    {
        $celeb = Celeb::factory()->create([
            'name' => 'Joe Generic',
            'date_of_birth' => Carbon::now()->subYears(30),
            'photo' => 'https://genericPhotos.com'
        ]);
        $user = User::factory()->create([
            'is_admin' => false
        ]);

        $this->actingAs($user)
            ->putJson("celebs/$celeb->id", [
                'id' => $celeb->id,
                'name' => 'Joe Invalid',
                'date_of_birth' => Carbon::now()->subYears(30),
                'photo' => 'https://genericPhotos.com'
            ])->assertRedirect();

        $this->assertDatabaseHas('celebs', [
            'id' => $celeb->id,
            'name' => 'Joe Generic',
            'date_of_birth' => Carbon::now()->subYears(30),
            'photo' => 'https://genericPhotos.com'
        ]);
    }

    /** @test */
    public function guest_cannot_update_a_celeb()
    {
        $celeb = Celeb::factory()->create([
            'name' => 'Joe Generic',
            'date_of_birth' => Carbon::now()->subYears(30),
            'photo' => 'https://genericPhotos.com'
        ]);

        $this->putJson("celebs/$celeb->id", [
            'id' => $celeb->id,
            'name' => 'Joe Invalid',
            'date_of_birth' => Carbon::now()->subYears(30),
            'photo' => 'https://genericPhotos.com'
        ])->assertRedirect();

        $this->assertDatabaseHas('celebs', [
            'id' => $celeb->id,
            'name' => 'Joe Generic',
            'date_of_birth' => Carbon::now()->subYears(30),
            'photo' => 'https://genericPhotos.com'
        ]);
    }

    /** @test */
    public function admin_can_delete_a_celeb()
    {
        $celeb = Celeb::factory()->create([
            'name' => 'Joe Generic',
            'date_of_birth' => Carbon::now()->subYears(30),
            'photo' => 'https://genericPhotos.com'
        ]);
        $admin = User::factory()->admin()->create();

        $this->assertDatabaseHas('celebs', [
            'id' => $celeb->id,
            'name' => 'Joe Generic',
            'date_of_birth' => Carbon::now()->subYears(30),
            'photo' => 'https://genericPhotos.com'
        ]);

        $this->actingAs($admin)
            ->deleteJson("celebs/$celeb->id")
            ->assertStatus(302);

        $this->assertDatabaseMissing('celebs', [
            'id' => $celeb->id,
            'name' => 'Joe Generic',
            'date_of_birth' => Carbon::now()->subYears(30),
            'photo' => 'https://genericPhotos.com'
        ]);
    }

    /** @test */
    public function user_cannot_delete_a_celeb()
    {
        $celeb = Celeb::factory()->create([
            'name' => 'Joe Generic',
            'date_of_birth' => Carbon::now()->subYears(30),
            'photo' => 'https://genericPhotos.com'
        ]);
        $user = User::factory()->create([
            'is_admin' => false
        ]);

        $this->actingAs($user)
            ->deleteJson("celebs/$celeb->id")
            ->assertRedirect();

        $this->assertDatabaseHas('celebs', [
            'id' => $celeb->id,
            'name' => 'Joe Generic',
            'date_of_birth' => Carbon::now()->subYears(30),
            'photo' => 'https://genericPhotos.com'
        ]);
    }

    /** @test */
    public function guest_cannot_delete_a_celeb()
    {
        $celeb = Celeb::factory()->create([
            'name' => 'Joe Generic',
            'date_of_birth' => Carbon::now()->subYears(30),
            'photo' => 'https://genericPhotos.com'
        ]);

        $this->deleteJson("celebs/$celeb->id")
            ->assertRedirect();

        $this->assertDatabaseHas('celebs', [
            'id' => $celeb->id,
            'name' => 'Joe Generic',
            'date_of_birth' => Carbon::now()->subYears(30),
            'photo' => 'https://genericPhotos.com'
        ]);
    }
}
