<?php

namespace Database\Seeders;

use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin = Role::create(['name' => 'admin']);
        $player = Role::create(['name' => 'player']);

        Permission::create(['name' => 'user.login'])->assignRole($player);
        Permission::create(['name' => 'user.register'])->assignRole($player);
        Permission::create(['name' => 'players.index'])->assignRole($player);
        Permission::create(['name' => 'players.update'])->assignRole($player);
        Permission::create(['name' => 'games.index'])->assignRole($player);
        Permission::create(['name' => 'games.throwTheDice'])->assignRole($player);
        Permission::create(['name' => 'games.destroy'])->assignRole($player);
        Permission::create(['name' => 'ranking.index'])->assignRole($admin);
        Permission::create(['name' => 'ranking.winner'])->assignRole($admin);
        Permission::create(['name' => 'ranking.loser'])->assignRole($admin);
        Permission::create(['name' => 'user.logout'])->assignRole($player);

    }
}
