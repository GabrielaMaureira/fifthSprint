<?php

namespace Tests\Feature;

//use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use Illuminate\Support\Facades\Hash;


class UserControllerTest extends TestCase
{
    
//use RefreshDatabase;

    public function test_a_user_can_register()
    {
        $this->withoutExceptionHandling();
        
        
        $user = [
            'name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'password' => bcrypt(123456),
        ];
        
        $response = $this->post(route('user.register'), $user);
    
        $response->assertStatus(201); 
    }

    public function test_a_user_can_login()
    {
        
        $user = User::factory()->create();

        $response = $this->postJson(route('user.login'), [
            'email' => $user->email,
            'password' => 'password', 
        ]);

        $response->assertOk();
        $response->assertJsonStructure([
            'message',
            'user',
            'auth_token',
        ]);
    }

    public function test_a_user_can_update_nickname()
    {
            
        $player = User::factory()->create()->assignRole('player');
        $token = $player->createToken('auth_token')->accessToken;
        $newName = 'New Player Name';
        $response = $this->actingAs($player, 'api')->json('PATCH', route('players.update', 
                                                            ['id' => $player->id]), 
                                                            ['name' => $newName],   
                                                            ['Authorization' => 'Bearer ' . $token]);
        $response->assertStatus(200);
        $this->assertDatabaseHas('users', [
            'id' => $player->id,
            'name' => $newName
        ]);
    }

    public function test_players_list_with_success_rate()
    {
    
        $admin = User::factory()->create()->assignRole('admin');
        $token = $admin->createToken('auth_token')->accessToken;

        $response = $this->actingAs($admin, 'api')->json('GET', route('players.index'), 
                                                            [], 
                                                            ['Authorization' => 'Bearer ' . $token]);
            

        $response->assertStatus(200);
        $response->Json();
        
    }
}
   
