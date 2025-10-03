<?php

namespace App\Http\Controllers\Home;

use Illuminate\Http\Request;
use App\Models\ProductCategory;
use App\Models\Product;
use App\Http\Controllers\Controller;

class HomeController extends Controller {
  public function index(){
  // Explicitly set foreign key name to match migration (category_id)
  $categories = ProductCategory::withCount(['products' => function($q){ $q->where('stock','>',0); }])->get();
    // show featured / new / top-selling (example: newest)
    $featured = Product::where('stock','>',0)->latest()->take(12)->get();
    return view('home', compact('categories','featured'));
  }
}