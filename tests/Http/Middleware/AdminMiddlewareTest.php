<?php

namespace Tests\Http\Middleware;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AdminMiddlewareTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        Route::get('/admin-route', function () {
            return 'nice';
        })->middleware(['web', 'admin']);
    }

    /** @test */
    public function non_admin_are_redirected()
    {
        $user = User::factory()->create([
            'is_admin' => false
        ]);

        $this->actingAs($user)
            ->getJson('/admin-route')
            ->assertRedirect();
    }

    /** @test */
    public function admin_are_not_redirected()
    {
        $admin = User::factory()->admin()->create();

        $this->actingAs($admin)
            ->getJson('/admin-route')
            ->assertOk();
    }
}
