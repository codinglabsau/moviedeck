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
    public function validation_produces_errors_when_admin_stores_celeb_with_one_invalid_data()
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
    }

    /** @test */
    public function validation_produces_errors_when_admin_stores_celeb_with_all_invalid_data()
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
    }

    /** @test */
    public function validation_error_when_admin_stores_celeb_with_date_of_birth_after_todays_date()
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
    }

    /** @test */
    public function validation_error_when_admin_stores_celeb_with_name_being_too_short()
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
    }

    /** @test */
    public function validation_error_when_admin_stores_celeb_with_name_being_too_long()
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
    }

    /** @test */
    public function user_cannot_create_a_celeb()
    {
        $user = User::factory()->create([
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
        $celeb = Celeb::factory()->create();
        $admin = User::factory()->admin()->create();

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
    public function validation_produces_errors_when_admin_updates_celeb_with_one_data_being_empty()
    {
        $celeb = Celeb::factory()->create();
        $admin = User::factory()->admin()->create();

        $this->actingAs($admin)
            ->put("celebs/$celeb->id", [
                'name' => 'Olivia Plankton',
                'date_of_birth' => '08/04/1994',
                'photo' => null
            ])->assertSessionHasErrors([
                'photo' => 'The photo field is required.'
            ]);
    }

    /** @test */
    public function validation_produces_errors_when_admin_updates_celeb_with_all_data_being_empty()
    {
        $celeb = Celeb::factory()->create();
        $admin = User::factory()->admin()->create();

        $this->actingAs($admin)
            ->put("celebs/$celeb->id", [
                'name' => null,
                'date_of_birth' => null,
                'photo' => null
            ])->assertSessionHasErrors([
                'name' => 'The name field is required.',
                'date_of_birth' => 'The date of birth field is required.',
                'photo' => 'The photo field is required.'
            ]);
    }

    /** @test */
    public function validation_error_when_admin_updates_celeb_with_date_of_birth_after_todays_date()
    {
        $celeb = Celeb::factory()->create();
        $admin = User::factory()->admin()->create();

        $this->actingAs($admin)
            ->put("celebs/$celeb->id", [
                'name' => 'James Islington',
                'date_of_birth' => '08/03/2999',
                'photo' => 'https://genericPhotos.com'
            ])->assertSessionHasErrors([
                'date_of_birth' => 'The date of birth must be a date before today.'
            ]);
    }

    /** @test */
    public function validation_error_when_admin_updates_celeb_with_name_being_too_short()
    {
        $celeb = Celeb::factory()->create();
        $admin = User::factory()->admin()->create();

        $this->actingAs($admin)
            ->put("celebs/$celeb->id", [
                'name' => 'P',
                'date_of_birth' => '08/03/2010',
                'photo' => 'https://genericPhotos.com'
            ])->assertSessionHasErrors([
                'name' => 'The name must be between 2 and 30 characters.'
            ]);
    }

    /** @test */
    public function validation_error_when_admin_updates_celeb_with_name_being_too_long()
    {
        $celeb = Celeb::factory()->create();
        $admin = User::factory()->admin()->create();

        $this->actingAs($admin)
            ->put("celebs/$celeb->id", [
                'name' => 'Beauregard Ofter-Jarms-Vendersenderson',
                'date_of_birth' => '08/03/1989',
                'photo' => 'https://genericPhoto.com'
            ])->assertSessionHasErrors([
                'name' => 'The name must be between 2 and 30 characters.'
            ]);
    }

    /** @test */
    public function user_cannot_update_celeb()
    {
        $celeb = Celeb::factory()->create();
        $user = User::factory()->create([
            'is_admin' => false
        ]);

        $this->actingAs($user)
            ->putJson("celebs/$celeb->id")
            ->assertRedirect();
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
