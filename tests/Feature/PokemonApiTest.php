<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Services\PokemonService;

class PokemonApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_unauthenticated_api_request_returns_401()
    {
        $response = $this->getJson('/api/pokemon/pikachu');
        $response->assertStatus(401);
    }

    public function test_authenticated_api_request_returns_data()
    {
        // Bind a simple stub that returns static data to avoid external calls
        $stub = new class extends PokemonService {
            public function __construct() {}
            public function get(string $nameOrId): array { return ['name' => $nameOrId]; }
        };
        $this->app->instance(PokemonService::class, $stub);

        $user = User::factory()->create();
        $this->actingAs($user, 'sanctum')
            ->getJson('/api/pokemon/pikachu')
            ->assertOk()
            ->assertJsonFragment(['name' => 'pikachu']);
    }
}
