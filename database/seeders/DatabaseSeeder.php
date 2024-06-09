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
        $this->call([RoleSeeder::class]);

        User::create([
            'name'=>'Anderson Admin',
            'email'=>'andy@admin.com',
            'password'=>Hash::make('123'),
        ])->assignRole('admin');

        User::create([
            'name'=>'Cuco Uno',
            'email'=>'cuco@admin.com',
            'password'=>Hash::make('123'),
        ])->assignRole('usuario');

        User::create([
            'name'=>'Cuco DOs',
            'email'=>'dos@admin.com',
            'password'=>Hash::make('123'),
        ])->assignRole('usuario');

        

    }
}
