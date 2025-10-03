<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Product;
use App\Models\ProductCategory;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        // Create admin user
        $this->call([\Database\Seeders\AdminUserSeeder::class]);

        // Categories
        $categories = collect(['Base Set','Jungle','Fossil','Team Rocket'])
            ->map(fn($name) => ProductCategory::firstOrCreate(['name' => $name], ['slug' => str($name)->slug()]));

        // Rich Pokemon card data for comprehensive testing
        $pokemonData = [
            ['name' => 'pikachu', 'id' => 25, 'rarity' => 'Rare', 'type' => 'Electric'],
            ['name' => 'charizard', 'id' => 6, 'rarity' => 'Ultra Rare', 'type' => 'Fire'],
            ['name' => 'bulbasaur', 'id' => 1, 'rarity' => 'Common', 'type' => 'Grass'],
            ['name' => 'squirtle', 'id' => 7, 'rarity' => 'Common', 'type' => 'Water'],
            ['name' => 'mewtwo', 'id' => 150, 'rarity' => 'Secret Rare', 'type' => 'Psychic'],
            ['name' => 'eevee', 'id' => 133, 'rarity' => 'Uncommon', 'type' => 'Normal'],
            ['name' => 'snorlax', 'id' => 143, 'rarity' => 'Rare', 'type' => 'Normal'],
            ['name' => 'gengar', 'id' => 94, 'rarity' => 'Rare', 'type' => 'Ghost'],
            ['name' => 'psyduck', 'id' => 54, 'rarity' => 'Common', 'type' => 'Water'],
            ['name' => 'jigglypuff', 'id' => 39, 'rarity' => 'Uncommon', 'type' => 'Normal'],
            ['name' => 'alakazam', 'id' => 65, 'rarity' => 'Ultra Rare', 'type' => 'Psychic'],
            ['name' => 'machamp', 'id' => 68, 'rarity' => 'Rare', 'type' => 'Fighting'],
            ['name' => 'dragonite', 'id' => 149, 'rarity' => 'Ultra Rare', 'type' => 'Dragon'],
            ['name' => 'blastoise', 'id' => 9, 'rarity' => 'Ultra Rare', 'type' => 'Water'],
            ['name' => 'venusaur', 'id' => 3, 'rarity' => 'Ultra Rare', 'type' => 'Grass'],
        ];

        $graders = ['PSA', 'BGS', 'CGC', 'SGC', ''];
        $grades = [null, 8, 8.5, 9, 9.5, 10];
        $editions = ['1st Edition', 'Unlimited', 'Shadowless', 'Limited Edition'];
        $holoTypes = ['None', 'Holo', 'Reverse Holo', 'Full Art', 'Secret Rare'];
        $artStyles = ['Classic Ken Sugimori', 'Modern Digital', 'Vintage Artwork', 'CGI Rendered', 'Hand Drawn'];
        $languages = ['English', 'Japanese', 'French', 'German', 'Spanish', 'Italian'];
        $releaseYears = [1998, 1999, 2000, 2001, 2002, 2003, 2004, 2005];

        foreach ($pokemonData as $i => $pokemon) {
            // Create multiple variants per Pokemon
            for ($variant = 0; $variant < 3; $variant++) {
                $cardTypes = ['Base', 'Holo', 'First Edition'];
                $cardType = $cardTypes[$variant];
                
                Product::create([
                    'category_id' => $categories[$i % $categories->count()]->id,
                    'pokemon_name' => $pokemon['name'],
                    'card_name' => ucfirst($pokemon['name']) . ' ' . $cardType,
                    'set_name' => $categories[$i % $categories->count()]->name,
                    'card_number' => sprintf('%03d', $pokemon['id']),
                    'grader' => $graders[($i + $variant) % count($graders)],
                    'grade' => $grades[($i + $variant) % count($grades)],
                    'release_year' => $releaseYears[($i + $variant) % count($releaseYears)],
                    'edition' => $editions[($i + $variant) % count($editions)],
                    'rarity' => $variant === 2 ? $pokemon['rarity'] : (['Common', 'Uncommon', 'Rare'][$variant]),
                    'holofoil_type' => $holoTypes[($i + $variant) % count($holoTypes)],
                    'art_style' => $artStyles[($i + $variant) % count($artStyles)],
                    'artist_name' => ['Ken Sugimori', 'Atsuko Nishida', 'Kouki Saitou'][($i + $variant) % 3],
                    'language' => $languages[($i + $variant) % count($languages)],
                    'collector_info' => 'Mint condition, ' . $pokemon['type'] . ' type Pokemon card from original series.',
                    'price' => rand(5, 500) + (rand(0, 99) / 100), // Random price with cents
                    'stock' => rand(0, 12),
                    'image_url' => "https://raw.githubusercontent.com/PokeAPI/sprites/master/sprites/pokemon/other/official-artwork/{$pokemon['id']}.png",
                ]);
            }
        }
    }
}
