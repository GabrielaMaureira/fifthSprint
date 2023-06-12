<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;


class UserControllerTest extends TestCase
{
    
use RefreshDatabase;

    public function test_a_user_can_register_with_valid_data()
    {
        \Artisan::call('passport:install');

        $user = [
            'name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'password' => 'Password',
            'password_confirmation' => 'Password',
            
        ];

        $this->postJson(route('user.register'), $user);

        unset($user['password']);
        unset($user['password_confirmation']);

        $this->assertDatabaseHas('users', $user);

    }

    public function test_a_user_can_register_with_no_name_and_anonymous_its_assigned()
    {
        \Artisan::call('passport:install');

        $user = [
            
            'email' => fake()->unique()->safeEmail(),
            'password' => 'Password',
            'password_confirmation' => 'Password',
            
        ];

        $this->postJson(route('user.register'), $user);

        $this->assertDatabaseHas('users', ['name' => 'Anonymous']);

    }

    public function test_a_user_can_login_with_valid_credentials()
    {
        $user = User::factory()->create();
        $credentials = [
            'email' => $user->email,
            'password' => 'Password',
        ];

        $this->actingAs($user)->postJson(route('user.login'), $credentials);
        
        $this->assertAuthenticated();
    }

    public function test_a_user_can_update_nickname_with_valid_data()
    {
        \Artisan::call('passport:install');
        
        $player = User::factory()->create()->assignRole(Role::create(['name' => 'player']));
        $token = $player->createToken('auth_token')->accessToken;

        $newName = 'New Player Name';

        $this->actingAs($player)->json('PATCH', route('players.update', ['id' => $player->id]), ['name' => $newName], ['Authorization' => 'Bearer ' . $token]);
        
        $this->assertDatabaseHas('users', ['id' => $player->id, 'name' => $newName]);
        
    }

    public function test_admin_can_see_player_list_with_success_rate()
    {
        \Artisan::call('passport:install');
        
        $user = User::factory()->create()->assignRole(Role::create(['name' => 'admin']));
        
        $token = $user->createToken('auth_token')->accessToken;

        $response = $this->actingAs($user, 'api')->json('GET', route('players.index'), [], ['Authorization' => 'Bearer ' . $token]);
            
        $response->assertStatus(200);
        $response->Json();
        
    }


}
   
