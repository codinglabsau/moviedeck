<?php

namespace Tests\Http\Middleware;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AdminCelebTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function admin_can_see_celebs_create_view()
    {
        $admin = \App\Models\User::factory()->create([
            'is_admin' => true
        ]);

        $this->actingAs($admin)
            ->getJson('celebs/create')
            ->assertOk();
    }

    /** @test */
    public function normal_user_cannot_see_celebs_create_view()
    {
        $user = \App\Models\User::factory()->create([
            'is_admin' => false
        ]);

        $this->actingAs($user)
            ->getJson('celebs/create')
            ->assertStatus(403);
    }

    /** @test */
    public function guest_cannot_see_celebs_create_view()
    {
        $this->getJson('celebs/create')
            ->assertStatus(403);
    }

    /** @test */
    public function admin_can_access_celebs_store()
    {
        $admin = \App\Models\User::factory()->create([
            'is_admin' => true
        ]);

        $this->actingAs($admin)
            ->postJson('celebs')
            ->assertOk();
    }

    /** @test */
    public function normal_user_cannot_access_celebs_store()
    {
        $user = \App\Models\User::factory()->create([
            'is_admin' => false
        ]);

        $this->actingAs($user)
            ->postJson('celebs')
            ->assertStatus(403);
    }

    /** @test */
    public function guest_cannot_access_celebs_store()
    {
        $this->postJson('celebs')
            ->assertStatus(403);
    }

    /** @test */
    public function admin_can_see_celebs_edit_view()
    {
        $celeb = \App\Models\Celeb::factory()->create();
        $admin = \App\Models\User::factory()->create([
            'is_admin' => true
        ]);

        $this->actingAs($admin)
            ->getJson("celebs/$celeb->id/edit")
            ->assertOk();
    }

    /** @test */
    public function normal_user_cannot_see_celebs_edit_view()
    {
        $celeb = \App\Models\Celeb::factory()->create();
        $user = \App\Models\User::factory()->create([
            'is_admin' => false
        ]);

        $this->actingAs($user)
            ->getJson("celebs/$celeb->id/edit")
            ->assertStatus(403);
    }

    /** @test */
    public function guest_cannot_see_celebs_edit_view()
    {
        $celeb = \App\Models\Celeb::factory()->create();
        $this->getJson("celebs/$celeb->id/edit")
            ->assertStatus(403);
    }

    /** @test */
    public function admin_can_access_celebs_update()
    {
        $celeb = \App\Models\Celeb::factory()->create();
        $admin = \App\Models\User::factory()->create([
            'is_admin' => true
        ]);

        $this->actingAs($admin)
            ->putJson("celebs/$celeb->id")
            ->assertOk();
    }

    /** @test */
    public function normal_user_cannot_access_celebs_update()
    {
        $celeb = \App\Models\Celeb::factory()->create();
        $user = \App\Models\User::factory()->create([
            'is_admin' => false
        ]);

        $this->actingAs($user)
            ->putJson("celebs/$celeb->id")
            ->assertStatus(403);
    }

    /** @test */
    public function guest_cannot_access_celebs_update()
    {
        $celeb = \App\Models\Celeb::factory()->create();
        $this->putJson("celebs/$celeb->id")
            ->assertStatus(403);
    }

    /** @test */
    public function admin_can_access_celebs_destroy()
    {
        $celeb = \App\Models\Celeb::factory()->create();
        $admin = \App\Models\User::factory()->create([
            'is_admin' => true
        ]);

        $this->actingAs($admin)
            ->deleteJson("celebs/$celeb->id")
            ->assertOk();
    }

    /** @test */
    public function normal_user_cannot_access_celebs_destroy()
    {
        $celeb = \App\Models\Celeb::factory()->create();
        $user = \App\Models\User::factory()->create([
            'is_admin' => false
        ]);

        $this->actingAs($user)
            ->deleteJson("celebs/$celeb->id")
            ->assertStatus(403);
    }

    /** @test */
    public function guest_cannot_access_celebs_destroy()
    {
        $celeb = \App\Models\Celeb::factory()->create();
        $this->deleteJson("celebs/$celeb->id")
            ->assertStatus(403);
    }
}
