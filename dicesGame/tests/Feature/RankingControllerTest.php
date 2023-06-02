<?php

namespace Tests\Feature;

//use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;
use Tests\TestCase;

class RankingControllerTest extends TestCase
{
    //use RefreshDatabase;

    public function test_application_can_calculate_average_success_rate_of_all_players()
    {
       
        $admin = User::factory()->create()->assignRole('admin');
        $token = $admin->createToken('auth_token')->accessToken;
        
        $response = $this->actingAs($admin, 'api')->json('GET', route('ranking.index'), [], ['Authorization' => 'Bearer ' . $token]);
    
        $response->assertStatus(200); 
        $response->Json();
    }

    public function test_application_can_calculate_winner()
    {
        
        $admin = User::factory()->create()->assignRole('admin');
        $token = $admin->createToken('auth_token')->accessToken;
        
        $response = $this->actingAs($admin, 'api')->json('GET', route('ranking.winner'), [], ['Authorization' => 'Bearer ' . $token]);
    
        $response->assertStatus(200); 
        $response->Json();
    }

    public function test_application_can_calculate_loser()
    {
        
        $admin = User::factory()->create()->assignRole('admin');
        $token = $admin->createToken('auth_token')->accessToken;
        
        $response = $this->actingAs($admin, 'api')->json('GET', route('ranking.loser'), [], ['Authorization' => 'Bearer ' . $token]);
    
        $response->assertStatus(200); 
        $response->Json();
    }
}
