<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\PokemonService;

class PokemonController extends Controller {
  protected PokemonService $poke;
  public function __construct(PokemonService $poke){ $this->poke = $poke; }
  public function show($name){
    $data = $this->poke->get($name);
    return response()->json($data);
  }
}