<?php
namespace App\Services;

use GuzzleHttp\Client;
use App\Models\PokemonCache;
use Carbon\Carbon;

class PokemonService
{
    protected Client $client;
    protected int $ttlMinutes = 60 * 24 * 7; // 7 days

    public function __construct()
    {
        $this->client = new Client([
            'base_uri' => 'https://pokeapi.co/api/v2/',
            'timeout'  => 8.0,
        ]);
    }

    public function get(string $nameOrId): array
    {
        $key = strtolower(trim($nameOrId));
        if ($key === '') {
            return [];
        }

        $now = Carbon::now();
        $staleData = null;

        // 1. Try cache
        try {
            $doc = PokemonCache::find($key);
            if ($doc) {
                $age = Carbon::parse($doc->fetched_at)->diffInMinutes($now);
                if ($age < $this->ttlMinutes && !empty($doc->data)) {
                    return $doc->data; // fresh
                }
                $staleData = $doc->data;
            }
        } catch (\Throwable $e) {
            // ignore cache read issues
        }

        // 2. API fetch
        try {
            $resp = $this->client->get("pokemon/{$key}");
            if ($resp->getStatusCode() !== 200) {
                return $staleData ?? [];
            }
            $data = json_decode($resp->getBody()->getContents(), true) ?? [];
        } catch (\Throwable $e) {
            return $staleData ?? [];
        }

        // 3. Upsert cache
        try {
            PokemonCache::updateOrCreate(
                ['_id' => $key],
                [
                    'name'       => $key,
                    'data'       => $data,
                    'fetched_at' => $now,
                ]
            );
        } catch (\Throwable $e) {
            // ignore write errors
        }

        return $data;
    }

    /**
     * Pick a sprite URL from a PokéAPI payload.
     */
    public function getSprite(array $pokeData): ?string
    {
        return $pokeData['sprites']['other']['official-artwork']['front_default']
            ?? $pokeData['sprites']['front_default']
            ?? $pokeData['sprites']['other']['dream_world']['front_default']
            ?? null;
    }
}
