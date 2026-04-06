<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\PermissionRegistrar;

class UsersSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        app(PermissionRegistrar::class)->forgetCachedPermissions();

        User::factory()->create([
            'name' => 'Admin',
            'email' => 'test_admin@example.com',
        ])->assignRole('admin');

        User::factory(2)->create()->each(function ($user) {
            $user->assignRole('manager');
        });
    }
}
