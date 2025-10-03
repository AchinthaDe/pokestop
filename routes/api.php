<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\PokemonController;

Route::middleware('auth:sanctum')->get('/pokemon/{name}', [PokemonController::class,'show']);

// NOTE: Token creation should not be done in a routes file.
// Create tokens in a controller or authentication flow, for example:
// $token = $user->createToken('mobile', ['place-orders'])->plainTextToken;