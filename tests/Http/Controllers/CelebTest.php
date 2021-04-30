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
        $admin = User::factory()->create([
            'is_admin' => true
        ]);

        $this->actingAs($admin)
            ->getJson('celebs/create')
            ->assertOk();
    }

    /** @test */
    public function normal_user_cannot_see_celebs_create_view()
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
    public function admin_can_access_celebs_store()
    {
        $admin = User::factory()->create([
            'is_admin' => true
        ]);

        $this->actingAs($admin)
            ->postJson('celebs')
            ->assertOk();
    }

    /** @test */
    public function normal_user_cannot_access_celebs_store()
    {
        $user = User::factory()->create([
            'is_admin' => false
        ]);

        $this->actingAs($user)
            ->postJson('celebs')
            ->assertRedirect();
    }

    /** @test */
    public function guest_cannot_access_celebs_store()
    {
        $this->postJson('celebs')
            ->assertRedirect();
    }

    /** @test */
    public function admin_can_see_celebs_edit_view()
    {
        $celeb = Celeb::factory()->create();
        $admin = User::factory()->create([
            'is_admin' => true
        ]);

        $this->actingAs($admin)
            ->getJson("celebs/$celeb->id/edit")
            ->assertOk();
    }

    /** @test */
    public function normal_user_cannot_see_celebs_edit_view()
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
    public function admin_can_access_celebs_update()
    {
        $celeb = Celeb::factory()->create();
        $admin = User::factory()->create([
            'is_admin' => true
        ]);

        $this->actingAs($admin)
            ->putJson("celebs/$celeb->id")
            ->assertOk();
    }

    /** @test */
    public function normal_user_cannot_access_celebs_update()
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
    public function guest_cannot_access_celebs_update()
    {
        $celeb = \App\Models\Celeb::factory()->create();
        $this->putJson("celebs/$celeb->id")
            ->assertRedirect();
    }

    /** @test */
    public function admin_can_access_celebs_destroy()
    {
        $celeb = Celeb::factory()->create();
        $admin = User::factory()->create([
            'is_admin' => true
        ]);

        $this->actingAs($admin)
            ->deleteJson("celebs/$celeb->id")
            ->assertOk();
    }

    /** @test */
    public function normal_user_cannot_access_celebs_destroy()
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
    public function guest_cannot_access_celebs_destroy()
    {
        $celeb = Celeb::factory()->create();
        $this->deleteJson("celebs/$celeb->id")
            ->assertRedirect();
    }
}
