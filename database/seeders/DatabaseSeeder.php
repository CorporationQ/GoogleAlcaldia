<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        $this->call(RoleSeeder::class);

        // Verificar si el usuario 'Anderson Admin' ya existe antes de crearlo
        if (!User::where('email', 'andy@admin.com')->exists()) {
            User::create([
                'name' => 'Anderson Admin',
                'email' => 'andy@admin.com',
                'password' => Hash::make('123'),
            ])->assignRole('administrator');
        }

        // Verificar si el usuario 'Cuco Uno' ya existe antes de crearlo
        if (!User::where('email', 'cuco@admin.com')->exists()) {
            User::create([
                'name' => 'Cuco Uno',
                'email' => 'cuco@admin.com',
                'password' => Hash::make('123'),
            ])->assignRole('regular_user');
        }

        // Verificar si el usuario 'Cuco Dos' ya existe antes de crearlo
        if (!User::where('email', 'dos@admin.com')->exists()) {
            User::create([
                'name' => 'Cuco Dos',
                'email' => 'dos@admin.com',
                'password' => Hash::make('123'),
            ])->assignRole('regular_user');
        }
    }
}