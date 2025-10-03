<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Services\PokemonService;

class AdminProductController extends Controller {
  public function index(){
    $products = Product::with('category')->latest()->paginate(20);
    return view('admin.products.index', compact('products'));
  }

  public function create() {
    $categories = ProductCategory::all();
    return view('admin.products.create', compact('categories'));
  }

  public function store(Request $r, PokemonService $poke) {
    $data = $r->validate([
      'pokemon_name' => 'required|string|max:255',
      'card_name' => 'nullable|string|max:255',
      'price' => 'required|numeric|min:0',
      'stock' => 'required|integer|min:0',
      'image_url' => 'nullable|url',
      // add other validations
    ]);

    // optionally fetch sprite if no image_url
    if (empty($data['image_url'])) {
      try {
        $apiData = $poke->get($data['pokemon_name']);
        $data['image_url'] = $poke->getSprite($apiData);
      } catch(\Exception $e){}
    }

    Product::create($data);
    return redirect()->route('admin.dashboard')->with('success','Product created');
  }

  public function edit(Product $product) {
    $categories = ProductCategory::all();
    return view('admin.products.edit', compact('product','categories'));
  }

  public function update(Request $r, Product $product) {
    $data = $r->validate([
      'pokemon_name' => 'required|string|max:255',
      'card_name' => 'nullable|string|max:255',
      'price' => 'required|numeric|min:0',
      'stock' => 'required|integer|min:0',
      'image_url' => 'nullable|url',
    ]);
    $product->update($data);
    return back()->with('success','Product updated');
  }
}