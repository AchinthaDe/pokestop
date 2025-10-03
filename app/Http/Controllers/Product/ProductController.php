<?php

namespace App\Http\Controllers\Product;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Services\PokemonService;

class ProductController extends Controller {
  public function show(Product $product, PokemonService $poke) {
    // fetch pokéapi data for the pokemon_name
    try {
      $pokeData = $poke->get($product->pokemon_name);
      $sprite = $poke->getSprite($pokeData);
    } catch (\Exception $e) {
      $pokeData = null;
      $sprite = null;
    }
    return view('products.show', compact('product','pokeData','sprite'));
  }

  public function browse(Request $request) {
    // handled with Livewire component; fallback server-side
    return view('products.browse');
  }
}