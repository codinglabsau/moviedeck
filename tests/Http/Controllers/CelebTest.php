<?php

namespace Tests\Http\Controllers;

use Tests\TestCase;
use App\Models\User;
use App\Models\Celeb;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CelebTest extends TestCase
{
    use RefreshDatabase;

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
            ->postJson('celebs', [
                'name' => 'John Farnaby',
                'date_of_birth' => '05/06/1988',
                'photo' => 'https://generic/photo_700x600'
            ])->assertSessionHasNoErrors();

        $this->assertDatabaseHas('celebs', [
            'name' => 'John Farnaby',
            'date_of_birth' => '05/06/1988',
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
                'date_of_birth' => '14/05/1996',
                'photo' => null
            ])->assertSessionHasErrors([
                'photo' => 'The photo field is required.'
            ]);

        $this->assertDatabaseMissing('celebs', [
            'name' => 'James Weatherby',
            'date_of_birth' => '14/05/1996',
            'photo' => null
        ]);
    }

    /** @test */
    public function validation_errors_when_celeb_has_all_invalid_data()
    {
        $admin = User::factory()->admin()->create();

        $this->actingAs($admin)
            ->post('celebs', [
                'name' => null,
                'date_of_birth' => null,
                'photo' => null
            ])->assertSessionHasErrors([
                'name' => 'The name field is required.',
                'date_of_birth' => 'The date of birth field is required.',
                'photo' => 'The photo field is required.']);

        $this->assertDatabaseMissing('celebs', [
            'name' => null,
            'date_of_birth' => null,
            'photo' => null
        ]);
    }

    /** @test */
    public function validation_error_when_celeb_date_of_birth_is_after_todays_date()
    {
        $admin= User::factory()->admin()->create();

        $this->actingAs($admin)
             ->post('celebs', [
                 'name' => 'William Invalid',
                 'date_of_birth' => '08/03/3000',
                 'photo' => 'https://genericPhoto2.com'
             ])->assertSessionHasErrors([
                 'date_of_birth' => 'The date of birth must be a date before today.'
            ]);

        $this->assertDatabaseMissing('celebs', [
            'name' => 'William Invalid',
            'date_of_birth' => '08/03/3000',
            'photo' => 'https://genericPhoto2.com'
        ]);
    }

    /** @test */
    public function validation_error_when_celeb_name_is_too_short()
    {
        $admin= User::factory()->admin()->create();

        $this->actingAs($admin)
            ->post('celebs', [
                'name' => 'J',
                'date_of_birth' => '08/03/2003',
                'photo' => 'https://genericPhoto2.com'
            ])->assertSessionHasErrors([
                'name' => 'The name must be between 2 and 30 characters.'
            ]);

        $this->assertDatabaseMissing('celebs', [
            'name' => 'J',
            'date_of_birth' => '08/03/2003',
            'photo' => 'https://genericPhoto2.com'
        ]);
    }

    /** @test */
    public function validation_error_when_celeb_name_is_too_long()
    {
        $admin= User::factory()->admin()->create();

        $this->actingAs($admin)
            ->post('celebs', [
                'name' => 'Ronald Gibons-Hacksonford-James III',
                'date_of_birth' => '08/03/2003',
                'photo' => 'https://genericPhoto2.com'
            ])->assertSessionHasErrors([
                'name' => 'The name must be between 2 and 30 characters.'
            ]);

        $this->assertDatabaseMissing('celebs', [
            'name' => 'Ronald Gibons-Hacksonford-James III',
            'date_of_birth' => '08/03/2003',
            'photo' => 'https://genericPhotos.com'
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
                'date_of_birth' => '10/11/1977',
                'photo' => 'https://genericPhotos.com'
            ])->assertRedirect();

        $this->assertDatabaseMissing('celebs', [
            'name' => 'Josie Jets',
            'date_of_birth' => '10/11/1977',
            'photo' => 'https://genericPhotos.com'
        ]);
    }

    /** @test */
    public function guest_cannot_create_a_celeb()
    {
        $this->postJson('celebs', [
            'name' => 'Joe Generic',
            'date_of_birth' => '01/01/2001',
            'photo' => 'https://genericPhotos.com'
        ])->assertRedirect();

        $this->assertDatabaseMissing('celebs', [
            'name' => 'Joe Generic',
            'date_of_birth' => '01/01/2001',
            'photo' => 'https://genericPhotos.com'
        ]);
    }

    /** @test */
    public function admin_can_see_celebs_edit_view()
    {
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
            'date_of_birth' => '27/11/1982',
            'photo' => 'https://generic/photo1_700x600'
        ]);
        $admin = User::factory()->admin()->create();

        $this->actingAs($admin)
            ->putJson("celebs/$celeb->id", [
                'name' => 'Jennifer Jaxon',
                'date_of_birth' => '27/11/1982',
                'photo' => 'https://generic/photo1_700x600'
            ])->assertSessionHasNoErrors();

        $this->assertDatabaseMissing('celebs', [
            'id' => $celeb->id,
            'name' => 'Jennifer Fallinbury',
            'date_of_birth' => '27/11/1982',
            'photo' => 'https://generic/photo1_700x600'
        ]);

        $this->assertDatabaseHas('celebs', [
            'id' => $celeb->id,
            'name' => 'Jennifer Jaxon',
            'date_of_birth' => '27/11/1982',
            'photo' => 'https://generic/photo1_700x600'
        ]);
    }

    /** @test */
    public function user_cannot_update_celeb()
    {
        $celeb = Celeb::factory()->create([
            'name' => 'Joe Generic',
            'date_of_birth' => '01/01/2001',
            'photo' => 'https://genericPhotos.com'
        ]);
        $user = User::factory()->create([
            'is_admin' => false
        ]);

        $this->actingAs($user)
            ->putJson("celebs/$celeb->id", [
                'id' => $celeb->id,
                'name' => 'Joe Invalid',
                'date_of_birth' => '01/01/2001',
                'photo' => 'https://genericPhotos.com'
            ])->assertRedirect();

        $this->assertDatabaseMissing('celebs', [
            'id' => $celeb->id,
            'name' => 'Joe Invalid',
            'date_of_birth' => '01/01/2001',
            'photo' => 'https://genericPhotos.com'
        ]);

        $this->assertDatabaseHas('celebs', [
            'id' => $celeb->id,
            'name' => 'Joe Generic',
            'date_of_birth' => '01/01/2001',
            'photo' => 'https://genericPhotos.com'
        ]);
    }

    /** @test */
    public function guest_cannot_update_a_celeb()
    {
        $celeb = Celeb::factory()->create();
        $this->putJson("celebs/$celeb->id")
            ->assertRedirect();
    }

    /** @test */
    public function admin_can_delete_a_celeb()
    {
        $admin = User::factory()->admin()->create();
        $celeb = Celeb::factory()->create();

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
        $celeb = Celeb::factory()->create();
        $user = User::factory()->create([
            'is_admin' => false
        ]);

        $this->actingAs($user)
            ->deleteJson("celebs/$celeb->id")
            ->assertRedirect();
    }

    /** @test */
    public function guest_cannot_delete_a_celeb()
    {
        $celeb = Celeb::factory()->create();
        $this->deleteJson("celebs/$celeb->id")
            ->assertRedirect();
    }
}
