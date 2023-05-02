<?php

namespace Tests\Feature;

//use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Game;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class GameControllerTest extends TestCase
{
    //use RefreshDatabase;

    public function test_a_player_can_get_their_game_list()
    {
        
        $player = User::factory()->create()->assignRole('player');
        $token = $player->createToken('auth_token')->accessToken;

        $games = Game::factory()->count(3)->create(['user_id' => $player->id]);

        $response = $this->actingAs($player, 'api')->json('GET', route('games.index', ['id' => $player->id]), [], ['Authorization' => 'Bearer ' . $token]);

        $response->assertStatus(200);
        $response->json();

    }

    public function test_a_player_can_throw_the_dice()
    {
        $player = User::factory()->create()->assignRole('player');
        $token = $player->createToken('auth_token')->accessToken;
        $response = $this->actingAs($player, 'api')->json('POST', route('games.throwTheDice', ['id' => $player->id]), ['Authorization' => 'Bearer ' . $token]);

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'result',
            'dice_1',
            'dice_2',
        ]);
    }

    public function test_a_player_can_delete_all_the_games()
    {
        $player = User::factory()
            ->has(\App\Models\Game::factory()->count(3))
            ->create()->assignRole('player');

        $token = $player->createToken('auth_token')->accessToken;
        $response = $this->actingAs($player, 'api')->delete(route('games.destroy', $player->id), ['Authorization' => 'Bearer ' . $token]);

        $response->assertStatus(200);

        $response->assertJson(['message' => 'Games have been deleted']);

        $this->assertEquals(0, $player->games()->count());
    }
}
