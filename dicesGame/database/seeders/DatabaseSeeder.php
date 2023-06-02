<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;


use Spatie\Permission\Models\Role;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use App\Models\User;


class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        
        
        $this->call(RoleSeeder::class);

         User::create([
            'name' => 'Administrator',
            'email' => 'admin@example.com',
            'email_verified_at' => now(),
            'password' => bcrypt(654321), // password
            'remember_token' => Str::random(10),
            
         ])->assignRole('admin');

         
        User::factory(2)
            ->has(\App\Models\Game::factory()->count(3))
            ->create()
            ->each(function ($user) {
                $user->assignRole('player');
            });
            
    }
    
}


    