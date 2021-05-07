<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(GenreSeeder::class);
        \App\Models\User::factory(20)->create();
        \App\Models\User::factory()->create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', //password
            'is_admin' => true
        ]);
        \App\Models\Movie::factory(100)->create();
        \App\Models\Review::factory(300)->create();
        \App\Models\Celeb::factory(100)->create();
        \App\Models\CelebMovie::factory(500)->create();
        \App\Models\GenreMovie::factory(200)->create();
        \App\Models\MovieUser::factory(100)->create();
    }
}
