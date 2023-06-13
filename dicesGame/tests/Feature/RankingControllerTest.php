<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;
use Tests\TestCase;
use Spatie\Permission\Models\Role;

class RankingControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_ok_response_when_everything_is_ok_on_players_list()
    {
        $admin = User::factory()->create()->assignRole(Role::create(['name' => 'admin']));

        $response = $this->actingAs($admin, 'api')->getJson(route('ranking.index'));

        $response->assertStatus(200);
    }

    public function test_user_has_no_access_to_player_list_without_auth()
    {
        User::factory()->create()->assignRole(Role::create(['name' => 'admin']));

        $response = $this->getJson(route('ranking.index'));

        $response->assertStatus(401);
    }

    public function test_a_user_with_player_role_can_see_player_list()
    {
        $player = User::factory()->create()->assignRole(Role::create(['name' => 'player']));

        $response = $this->actingAs($player, 'api')->getJson(route('ranking.index'));

        $response->assertStatus(200);
    }

    public function test_ok_response_when_everything_is_ok_with_winner_return()
    {
        $admin = User::factory()->create()->assignRole(Role::create(['name' => 'admin']));
        
        $response = $this->actingAs($admin, 'api')->getJson(route('ranking.winner'));
    
        $response->assertStatus(200); 
    }

    public function test_admin_role_has_access_to_see_the_winner()
    {
        $admin = User::factory()->create()->assignRole(Role::create(['name' => 'admin']));
        
        $response = $this->actingAs($admin, 'api')->getJson(route('ranking.winner'));
    
        $response->assertStatus(200); 
        
    }

    public function test_player_role_has_not_access_to_see_the_winner()
    {
        $player = User::factory()->create()->assignRole(Role::create(['name' => 'player']));

        $response = $this->actingAs($player, 'api')->getJson(route('ranking.winner'));

        $response->assertStatus(403); 
    }

    public function test_ok_response_when_everything_is_ok_with_loser_return()
    {
        $admin = User::factory()->create()->assignRole(Role::create(['name' => 'admin']));
        
        $response = $this->actingAs($admin, 'api')->getJson(route('ranking.loser'));
    
        $response->assertStatus(200); 
    }

    public function test_a_user_with_player_role_has_not_access_to_loser_list()
    {
        $player = User::factory()->create()->assignRole(Role::create(['name' => 'player']));
        
        $response = $this->actingAs($player, 'api')->getJson(route('ranking.loser'));
    
        $response->assertStatus(403); 
    }
}
