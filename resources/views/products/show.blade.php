@extends('layouts.app')
@section('content')
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
  <div class="col-span-2 retro-card p-6">
    <div class="flex gap-6">
      <img src="{{ $product->image_url }}" class="w-64 object-contain" alt="">
      <div>
  <h1 class="retro-h1">{{ $product->card_name ?? $product->pokemon_name }}</h1>
  <p class="text-sm text-green-300/70">{{ $product->grader ? "{$product->grader} - {$product->grade}" : '' }}</p>
  <p class="mt-4 text-green-200/80">{{ $product->collector_info }}</p>
        <div class="mt-4">
          <span class="text-xl font-bold text-green-300">₹{{ number_format($product->price,2) }}</span>
          <form action="{{ route('cart.add', $product) }}" method="POST" class="inline-block ml-4">
            @csrf
            <button class="retro-btn">Add to Cart</button>
          </form>
        </div>
      </div>
    </div>

    <hr class="my-6">

    <h3 class="retro-h2">PokéAPI info</h3>
    @if($pokeData)
      <div class="mt-3 flex gap-6 items-start">
  <img src="{{ $sprite }}" class="w-32 border border-green-400/40 rounded" alt="sprite" />
        <div>
          <div><strong>Name:</strong> {{ $pokeData['name'] ?? '' }}</div>
          <div><strong>Types:</strong> {{ collect($pokeData['types'] ?? [])->pluck('type.name')->join(', ') }}</div>
          <div class="mt-2">
            <strong>Stats</strong>
            <ul class="list-disc ml-6">
              @foreach($pokeData['stats'] ?? [] as $s)
                <li>{{ $s['stat']['name'] }}: {{ $s['base_stat'] }}</li>
              @endforeach
            </ul>
          </div>
        </div>
      </div>
    @else
      <p class="text-gray-500">PokéAPI info not available.</p>
    @endif
  </div>

  <aside class="retro-card p-6">
    <h4 class="font-semibold">Details</h4>
    <ul class="text-sm text-gray-700 mt-3">
      <li><strong>Set:</strong> {{ $product->set_name }}</li>
      <li><strong>Card:</strong> {{ $product->card_number }}</li>
      <li><strong>Release year:</strong> {{ $product->release_year }}</li>
      <li><strong>Stock:</strong> {{ $product->stock }}</li>
    </ul>
  </aside>
</div>
@endsection
