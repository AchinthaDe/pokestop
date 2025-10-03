@extends('layouts.app')

@section('content')
<div class="px-hero">
  <div class="px-flyer-layer overflow-visible">
    <div class="px-flyer">
      <img src="{{ asset('images/lugia-silhouette.png') }}" alt="Lugia" loading="eager">
    </div>
  </div>
    <h1 class="px-hero-title">PokéStop</h1>
    <p class="px-hero-sub">Rare Pokémon Card Collection Database</p>
    <a href="{{ route('products.browse') }}" class="px-btn px-btn-primary px-hero-cta">Browse Collection</a>
</div>

<section class="mt-8">
  <h2 class="px-section-title">Card Series Database</h2>
  <div class="px-grid px-grid-3">
    @forelse($categories as $cat)
      <a href="{{ route('products.browse', ['category' => $cat->id]) }}" class="px-card group">
        <div class="px-card-title mb-2">{{ $cat->name }}</div>
        <div class="px-card-meta">{{ $cat->products_count }} RECORDS</div>
      </a>
    @empty
      <div class="px-center px-muted px-grid-full">NO DATA</div>
    @endforelse
  </div>
</section>

<section class="mt-16">
  <h2 class="px-section-title">Featured Cards</h2>
  <div class="px-grid px-grid-3">
    @forelse($featured as $product)
      <x-product-card :product="$product" />
    @empty
      <div class="px-card px-center px-grid-full">Loading…</div>
    @endforelse
  </div>
</section>
@endsection
