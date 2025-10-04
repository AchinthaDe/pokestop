<?php
// Quick seeder script to populate Pokemon cards from pocketslabs.com

require __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\Product;
use App\Models\ProductCategory;

echo "Starting Pokemon Cards Seeder...\n";

// Create categories
$vintage = ProductCategory::create(['name' => 'Vintage Cards', 'slug' => 'vintage-cards']);
$modern = ProductCategory::create(['name' => 'Modern Cards', 'slug' => 'modern-cards']);
$graded = ProductCategory::create(['name' => 'Graded Cards', 'slug' => 'graded-cards']);
$japanese = ProductCategory::create(['name' => 'Japanese Cards', 'slug' => 'japanese-cards']);

echo "✅ Created 4 categories\n";

// Pokemon cards data from pocketslabs.com
$cards = [
    ['pokemon' => 'Ninetales', 'number' => 12, 'name' => '1999 Pokemon Base Set Shadowless Holo Ninetales #12', 'set' => 'Base Set Shadowless', 'year' => 1999, 'grader' => 'CGC', 'grade' => 10, 'price' => 1095.00, 'stock' => 1, 'category' => $vintage],
    ['pokemon' => 'Drowzee', 'number' => 59, 'name' => '2017 Pokemon Sun & Moon Drowzee #59', 'set' => 'Sun & Moon', 'year' => 2017, 'grader' => 'CGC', 'grade' => 10, 'price' => 40.00, 'stock' => 1, 'category' => $graded],
    ['pokemon' => 'Sandy Shocks', 'number' => 250, 'name' => '2023 Pokemon Paradox Rift Sandy Shocks Ex #250', 'set' => 'Paradox Rift', 'year' => 2023, 'grader' => 'CGC', 'grade' => 10, 'price' => 30.00, 'stock' => 2, 'category' => $modern],
    ['pokemon' => 'Raikou', 'number' => 41, 'name' => '2023 Pokemon Crown Zenith Raikou V #GG41', 'set' => 'Crown Zenith', 'year' => 2023, 'grader' => 'CGC', 'grade' => 10, 'price' => 65.00, 'stock' => 3, 'category' => $modern],
    ['pokemon' => 'Entei', 'number' => 8, 'name' => '2003 Pokemon Aquapolis Holo Entei #H8', 'set' => 'Aquapolis', 'year' => 2003, 'grader' => 'PSA', 'grade' => 9, 'price' => 400.00, 'stock' => 1, 'category' => $vintage],
    ['pokemon' => 'Grimer', 'number' => 56, 'name' => '2004 Pokemon Ex Team Rocket Returns Reverse Holo Grimer #56', 'set' => 'Ex Team Rocket Returns', 'year' => 2004, 'grader' => 'PSA', 'grade' => 9, 'price' => 120.00, 'stock' => 2, 'category' => $vintage],
    ['pokemon' => 'Meltan', 'number' => 179, 'name' => '2024 Pokemon Temporal Forces IR Meltan #179', 'set' => 'Temporal Forces', 'year' => 2024, 'grader' => 'TAG', 'grade' => 6, 'price' => 8.00, 'stock' => 5, 'category' => $modern],
    ['pokemon' => 'Absol', 'number' => 34, 'name' => '2003 Pokemon Japanese 7-Eleven Fair Promo Absol #34/ADV-P', 'set' => '7-Eleven Fair Promo', 'year' => 2003, 'grader' => 'TAG', 'grade' => 9, 'price' => 50.00, 'stock' => 1, 'category' => $japanese],
    ['pokemon' => 'Pikachu', 'number' => 160, 'name' => '2023 Pokemon Crown Zenith Pikachu #160', 'set' => 'Crown Zenith', 'year' => 2023, 'grader' => 'TAG', 'grade' => 10, 'price' => 245.00, 'stock' => 2, 'category' => $modern],
    ['pokemon' => 'Arceus', 'number' => 36, 'name' => '2015 Pokemon Legendary Shine Collection 1st Edition Arceus #36', 'set' => 'Legendary Shine Collection', 'year' => 2015, 'grader' => 'TAG', 'grade' => 9, 'price' => 100.00, 'stock' => 1, 'category' => $japanese],
    ['pokemon' => 'Zeraora', 'number' => 43, 'name' => '2023 Pokemon Crown Zenith Zeraora Vstar #GG43', 'set' => 'Crown Zenith', 'year' => 2023, 'grader' => 'TAG', 'grade' => 10, 'price' => 70.00, 'stock' => 3, 'category' => $modern],
    ['pokemon' => 'Roserade', 'number' => 184, 'name' => '2025 Pokemon Destined Rivals IR Cynthia\'s Roserade #184', 'set' => 'Destined Rivals', 'year' => 2025, 'grader' => 'TAG', 'grade' => 10, 'price' => 140.00, 'stock' => 2, 'category' => $modern],
    ['pokemon' => 'Mew', 'number' => 53, 'name' => '2016 Pokemon XY Evolutions Holo Mew #53', 'set' => 'XY Evolutions', 'year' => 2016, 'grader' => 'PSA', 'grade' => 9, 'price' => 52.00, 'stock' => 4, 'category' => $modern],
    ['pokemon' => 'Gyarados', 'number' => 23, 'name' => '2015 Pokemon Japanese XY Rage Broken Heavens 1st Ed Full Art Gyarados EX', 'set' => 'XY Rage Broken Heavens', 'year' => 2015, 'grader' => 'PSA', 'grade' => 8, 'price' => 52.00, 'stock' => 2, 'category' => $japanese],
    ['pokemon' => 'Zoroark', 'number' => 185, 'name' => '2025 Pokemon SV Journey Together SIR N\'s Zoroark ex #185', 'set' => 'SV Journey Together', 'year' => 2025, 'grader' => 'PSA', 'grade' => 9, 'price' => 56.00, 'stock' => 3, 'category' => $modern],
    ['pokemon' => 'Charizard', 'number' => 6, 'name' => '1999 Pokemon Base Set Holo Charizard #4', 'set' => 'Base Set', 'year' => 1999, 'grader' => 'PSA', 'grade' => 10, 'price' => 5500.00, 'stock' => 1, 'category' => $vintage],
    ['pokemon' => 'Blastoise', 'number' => 9, 'name' => '1999 Pokemon Base Set Holo Blastoise #2', 'set' => 'Base Set', 'year' => 1999, 'grader' => 'PSA', 'grade' => 9, 'price' => 850.00, 'stock' => 1, 'category' => $vintage],
    ['pokemon' => 'Venusaur', 'number' => 3, 'name' => '1999 Pokemon Base Set Holo Venusaur #15', 'set' => 'Base Set', 'year' => 1999, 'grader' => 'CGC', 'grade' => 9, 'price' => 780.00, 'stock' => 1, 'category' => $vintage],
    ['pokemon' => 'Mewtwo', 'number' => 150, 'name' => '2000 Pokemon Base Set 2 Holo Mewtwo #10', 'set' => 'Base Set 2', 'year' => 2000, 'grader' => 'PSA', 'grade' => 10, 'price' => 320.00, 'stock' => 2, 'category' => $vintage],
    ['pokemon' => 'Lugia', 'number' => 249, 'name' => '2000 Pokemon Neo Genesis Holo Lugia #9', 'set' => 'Neo Genesis', 'year' => 2000, 'grader' => 'BGS', 'grade' => 9, 'price' => 650.00, 'stock' => 1, 'category' => $vintage],
];

$count = 0;
$total = 0;

foreach ($cards as $card) {
    Product::create([
        'category_id' => $card['category']->id,
        'pokemon_name' => $card['pokemon'],
        'card_number' => (string)$card['number'],
        'card_name' => $card['name'],
        'set_name' => $card['set'],
        'grader' => $card['grader'],
        'grade' => $card['grade'],
        'release_year' => $card['year'],
        'price' => $card['price'],
        'stock' => $card['stock'],
        'image_url' => null,
        'collector_info' => 'Professionally graded ' . $card['grader'] . ' ' . $card['grade'] . ' Pokemon card from ' . $card['set'] . ' set.',
    ]);
    $count++;
    $total += $card['price'];
}

echo "✅ Successfully seeded {$count} Pokemon cards from pocketslabs.com!\n";
echo "💎 Total collection value: $" . number_format($total, 2) . "\n";
echo "📦 Categories: Vintage, Modern, Graded, and Japanese cards\n";
