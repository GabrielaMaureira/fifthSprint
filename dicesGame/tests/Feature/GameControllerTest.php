<?php

namespace Tests\Feature;

use App\Models\Game;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Spatie\Permission\Models\Role;

class GameControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_a_player_can_get_their_game_list()
    {
        $player = User::factory()->create()->assignRole(Role::create(['name' => 'player']));

        $response = $this->actingAs($player, 'api')->getJson(route('ranking.index'));

        $response->assertStatus(200);

    }

    public function test_a_player_can_throw_the_dice()
    {
        $player = User::factory()->create()->assignRole(Role::create(['name' => 'player']));
        
        $response = $this->actingAs($player, 'api')->postJson(route('games.throwTheDice', $player->id));

        $response->assertStatus(200);
    }

    public function test_a_player_can_delete_all_the_games()
    {
        $player = User::factory()
            ->has(\App\Models\Game::factory()->count(3))
            ->create()->assignRole(Role::create(['name' => 'player']));

        $this->actingAs($player, 'api')->deleteJson(route('games.destroy', $player->id));
        
        $this->assertEquals(0, $player->games()->count());
    }

}
