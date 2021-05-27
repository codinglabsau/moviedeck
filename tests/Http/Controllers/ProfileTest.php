<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProfileTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function admin_can_see_profile_dashboard_view()
    {
        $admin = User::factory()->admin()->create();

        $this->actingAs($admin)
            ->getJson(route('profile.dashboard', $admin->id))
            ->assertOk();
    }

    /** @test */
    public function user_can_see_profile_dashboard_view()
    {
        $user = User::factory()->create([
            'is_admin' => false
        ]);

        $this->actingAs($user)
            ->getJson(route('profile.dashboard', $user->id))
            ->assertOk();
    }

    /** @test */
    public function guest_cannot_see_profile_dashboard_view()
    {
        $user = User::factory()->create([
            'is_admin' => false
        ]);

        $this->getJson(route('profile.dashboard', $user->id))
            ->assertStatus(401); //unauthorised
    }

    /** @test */
    public function admin_can_see_profile_reviews_view()
    {
        $admin = User::factory()->admin()->create();

        $this->actingAs($admin)
            ->getJson(route('profile.reviews', $admin->id))
            ->assertOk();
    }

    /** @test */
    public function user_can_see_profile_reviews_view()
    {
        $user = User::factory()->create([
            'is_admin' => false
        ]);

        $this->actingAs($user)
            ->getJson(route('profile.reviews', $user->id))
            ->assertOk();
    }

    /** @test */
    public function guest_cannot_see_profile_reviews_view()
    {
        $user = User::factory()->create([
            'is_admin' => false
        ]);

        $this->getJson(route('profile.reviews', $user->id))
            ->assertStatus(401); //unauthorised
    }

    /** @test */
    public function admin_can_see_own_profile_edit_view()
    {
        $admin = User::factory()->admin()->create();

        $this->actingAs($admin)
            ->getJson(route('profile.edit', $admin->id))
            ->assertOk();
    }

    /** @test */
    public function admin_can_see_others_profile_edit_view()
    {
        $admin = User::factory()->admin()->create();
        $user = User::factory()->create([
            'is_admin' => false
        ]);

        $this->actingAs($admin)
            ->getJson(route('profile.edit', $user->id))
            ->assertOk();
    }

    /** @test */
    public function user_can_see_own_profile_edit_view()
    {
        $user = User::factory()->create([
            'is_admin' => false
        ]);

        $this->actingAs($user)
            ->getJson(route('profile.edit', $user->id))
            ->assertOk();
    }

    /** @test */
    public function user_cannot_see_others_profile_edit_view()
    {
        $user1 = User::factory()->create([
            'is_admin' => false
        ]);
        $user2 = User::factory()->create([
            'is_admin' => false
        ]);

        $this->actingAs($user1)
            ->getJson(route('profile.edit', $user2->id))
            ->assertRedirect('/');
    }

    /** @test */
    public function guest_cannot_see_profile_edit_view()
    {
        $user = User::factory()->create([
            'is_admin' => false
        ]);

        $this->getJson(route('profile.reviews', $user->id))
            ->assertStatus(401); //unauthorised
    }

    /** @test */
    public function admin_can_update_own_profile()
    {
        $admin = User::factory()->admin()->create([
            'username' => 'GenericAdmin',
            'name' => 'Admin Generic',
            'avatar' => 'https://genericAvatars.com',
            'about_me' => 'This is a sample bit about me'
        ]);

        $this->actingAs($admin)
            ->putJson(route('profile.update', $admin->id), [
                'username' => 'ChangedAdmin',
                'name' => 'Admin Changed',
                'avatar' => 'https://differentAvatars.com',
                'about_me' => 'This is a changed bit about me'
            ])->assertStatus(302);

        $this->assertDatabaseHas('users', [
            'id' => $admin->id,
            'username' => 'ChangedAdmin',
            'name' => 'Admin Changed',
            'email' => $admin->email,
            'password' => $admin->password,
            'avatar' => 'https://differentAvatars.com',
            'about_me' => 'This is a changed bit about me',
            'is_admin' => $admin->is_admin
        ]);
    }

    /** @test */
    public function admin_cannot_update_others_profile()
    {
        $admin = User::factory()->admin()->create();
        $user = User::factory()->create([
            'username' => 'GenericMan',
            'name' => 'Joe Generic',
            'avatar' => 'https://genericAvatars.com',
            'about_me' => 'This is a sample bit about me',
            'is_admin' => false
        ]);

        $this->actingAs($admin)
            ->putJson(route('profile.update', $user->id), [
                'username' => 'ChangedMan',
                'name' => 'Joe Changed',
                'avatar' => 'https://differentAvatars.com',
                'about_me' => 'This is a changed bit about me'
            ])->assertStatus(302);

        $this->assertDatabaseMissing('users', [
            'id' => $user->id,
            'username' => 'ChangedMan',
            'name' => 'Joe Changed',
            'email' => $user->email,
            'password' => $user->password,
            'avatar' => 'https://differentAvatars.com',
            'about_me' => 'This is a changed bit about me',
            'is_admin' => $user->is_admin
        ]);
    }

    /** @test */
    public function user_can_update_own_profile()
    {
        $user = User::factory()->create([
            'username' => 'GenericMan',
            'name' => 'Joe Generic',
            'avatar' => 'https://genericAvatars.com',
            'about_me' => 'This is a sample bit about me',
            'is_admin' => false
        ]);

        $this->actingAs($user)
            ->putJson(route('profile.update', $user->id), [
                'username' => 'ChangedMan',
                'name' => 'Joe Changed',
                'avatar' => 'https://differentAvatars.com',
                'about_me' => 'This is a changed bit about me'
            ])->assertStatus(302);

        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'username' => 'ChangedMan',
            'name' => 'Joe Changed',
            'email' => $user->email,
            'password' => $user->password,
            'avatar' => 'https://differentAvatars.com',
            'about_me' => 'This is a changed bit about me',
            'is_admin' => $user->is_admin
        ]);
    }

    /** @test */
    public function user_cannot_update_others_profile()
    {
        $user1 = User::factory()->create([
            'is_admin' => false
        ]);
        $user2 = User::factory()->create([
            'username' => 'GenericMan',
            'name' => 'Joe Generic',
            'avatar' => 'https://genericAvatars.com',
            'about_me' => 'This is a sample bit about me',
            'is_admin' => false
        ]);

        $this->actingAs($user1)
            ->putJson(route('profile.update', $user2->id), [
                'username' => 'ChangedMan',
                'name' => 'Joe Changed',
                'avatar' => 'https://differentAvatars.com',
                'about_me' => 'This is a changed bit about me'
            ])->assertStatus(302);

        $this->assertDatabaseMissing('users', [
            'id' => $user2->id,
            'username' => 'ChangedMan',
            'name' => 'Joe Changed',
            'email' => $user2->email,
            'password' => $user2->password,
            'avatar' => 'https://differentAvatars.com',
            'about_me' => 'This is a changed bit about me',
            'is_admin' => $user2->is_admin
        ]);
    }

    /** @test */
    public function guest_cannot_update_profile()
    {
        $user = User::factory()->create([
            'username' => 'GenericMan',
            'name' => 'Joe Generic',
            'avatar' => 'https://genericAvatars.com',
            'about_me' => 'This is a sample bit about me',
            'is_admin' => false
        ]);

        $this->putJson(route('profile.update', $user->id), [
            'username' => 'ChangedMan',
            'name' => 'Joe Changed',
            'avatar' => 'https://differentAvatars.com',
            'about_me' => 'This is a changed bit about me'
        ])->assertStatus(401); //unauthorised

        $this->assertDatabaseMissing('users', [
            'id' => $user->id,
            'username' => 'ChangedMan',
            'name' => 'Joe Changed',
            'email' => $user->email,
            'password' => $user->password,
            'avatar' => 'https://differentAvatars.com',
            'about_me' => 'This is a changed bit about me',
            'is_admin' => $user->is_admin
        ]);
    }

    /** @test */
    public function validation_error_when_username_already_exists()
    {
        $user = User::factory()->create();
        $existingName = User::factory()->create([
            'username' => 'InvalidUser'
        ]);

        $this->actingAs($user)
            ->put(route('profile.update', $user->id), [
                'username' => $existingName->username,
                'name' => 'Joe Generic',
                'avatar' => 'https://genericAvatars.com',
                'about_me' => 'This is a sample bit about me'
            ])->assertSessionHasErrors([
                'username' => 'The username has already been taken.'
            ]);
    }

    /** @test */
    public function validation_error_when_data_is_missing()
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->put(route('profile.update', $user->id), [
                'username' => null,
                'name' => null,
                'avatar' => null,
                'about_me' => null
            ])->assertSessionHasErrors([
                'username' => 'The username field is required.',
                'name' => 'The name field is required.',
                'avatar' => 'The avatar field is required.'
            ]);
    }

    /** @test */
    public function validation_error_when_about_me_is_too_long()
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->put(route('profile.update', $user->id), [
                'username' => 'GenericUser',
                'name' => 'Joe Generic',
                'avatar' => 'https://genericAvatars.com',
                'about_me' => 'Temporibus vel non ea ex. Et et a voluptas et rerum corrupti.
                               Quia quidem unde voluptatum consequatur sed quis. Id et ipsam sunt qui ab id.
                               Sunt at sit ea hic repudiandae omnis nostrum. Adipisci quis facilis ducimus.
                               Architecto commodi ipsam voluptates. Qui et in aliquam ut dolorem inventore ut.
                               Esse sit reprehenderit enim pariatur eligendi eum.'
            ])->assertSessionHasErrors([
                'about_me' => 'The about me must not be greater than 200 characters.'
            ]);
    }

    /** @test */
    public function no_validation_error_when_username_is_unchanged()
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->put(route('profile.update', $user->id), [
                'username' => $user->username,
                'name' => 'Joe Generic',
                'avatar' => 'https://genericAvatars.com',
                'about_me' => 'This is a sample bit about me'
            ])->assertSessionHasNoErrors();
    }

    /** @test */
    public function admin_can_make_another_user_an_admin()
    {
        $admin = User::factory()->admin()->create();
        $user = User::factory()->create([
            'is_admin' => false
        ]);

        $this->actingAs($admin)
            ->patchJson("profile/$user->id")
            ->assertStatus(302);

        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'is_admin' => true
        ]);
    }

    /** @test */
    public function user_cannot_make_another_user_an_admin()
    {
        $user1 = User::factory()->create([
            'is_admin' => false
        ]);
        $user2 = User::factory()->create([
            'is_admin' => false
        ]);

        $this->actingAs($user1)
            ->patchJson("profile/$user2->id")
            ->assertRedirect('/');

        $this->assertDatabaseHas('users', [
            'id' => $user2->id,
            'is_admin' => false
        ]);
    }

    /** @test */
    public function guest_cannot_make_another_user_an_admin()
    {
        $user = User::factory()->create([
            'is_admin' => false
        ]);

        $this->patchJson("profile/$user->id")
            ->assertRedirect('/');

        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'is_admin' => false
        ]);
    }

    /** @test */
    public function admin_can_remove_another_user_as_an_admin()
    {
        $admin = User::factory()->admin()->create();
        $user = User::factory()->admin()->create();

        $this->actingAs($admin)
            ->patchJson("profile/$user->id/edit")
            ->assertStatus(302);

        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'is_admin' => false
        ]);
    }

    /** @test */
    public function user_cannot_remove_another_user_as_an_admin()
    {
        $user1 = User::factory()->create([
            'is_admin' => false
        ]);
        $admin = User::factory()->admin()->create();

        $this->actingAs($user1)
            ->patchJson("profile/$admin->id")
            ->assertRedirect('/');

        $this->assertDatabaseHas('users', [
            'id' => $admin->id,
            'is_admin' => true
        ]);
    }

    /** @test */
    public function guest_cannot_remove_another_user_as_an_admin()
    {
        $admin = User::factory()->admin()->create();

        $this->patchJson("profile/$admin->id")
            ->assertRedirect('/');

        $this->assertDatabaseHas('users', [
            'id' => $admin->id,
            'is_admin' => true
        ]);
    }
}

