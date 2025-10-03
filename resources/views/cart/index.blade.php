@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto">
  <h2 class="px-section-title">Shopping Cart</h2>

  @php $items = $cart->items ?? collect(); @endphp

  @if($items->isEmpty())
    <div class="px-card px-center px-cart-empty">
      <div class="px-muted mb-4">YOUR CART IS EMPTY</div>
      <a href="{{ route('products.browse') }}" class="px-btn px-btn-primary px-inline">Browse Collection</a>
    </div>
  @else
    <div class="px-panel">
      <div class="space-y-4">
        @foreach($items as $item)
          @php
            $product = $item->product;
            $lineTotal = $item->price * $item->quantity;
          @endphp
          <div class="flex items-start gap-4 pb-4 border-b border-[#163e60] last:border-0">
            {{-- Product Image --}}
            <div class="px-cart-image">
              @if($product)
                @php $img = $product->image_url ?: 'https://raw.githubusercontent.com/PokeAPI/sprites/master/sprites/pokemon/other/official-artwork/25.png'; @endphp
                <img src="{{ $img }}" alt="{{ $product->card_name ?? $product->pokemon_name }}" class="w-full h-full object-contain">
              @endif
            </div>

            {{-- Product Info --}}
            <div class="flex-1 min-w-0">
              <h3 class="px-card-title text-base mb-1">
                {{ $product->card_name ?? $product->pokemon_name ?? 'Product #'.$item->product_id }}
              </h3>
              <div class="px-card-meta text-xs space-y-0.5">
                @if($product && $product->set_name)
                  <div>{{ $product->set_name }}</div>
                @endif
                @if($product && $product->rarity)
                  <div>{{ ucfirst($product->rarity) }}</div>
                @endif
              </div>
              <div class="mt-2 flex items-center gap-3">
                <span class="px-muted text-[.6rem] tracking-wider">QTY:</span>
                <form method="POST" action="{{ route('cart.update', $item->product_id) }}" class="flex items-center gap-2">
                  @csrf
                  <input type="number" name="quantity" value="{{ $item->quantity }}" min="0" max="99" 
                         class="px-input px-input-sm w-16 text-center">
                  <button type="submit" class="px-btn px-btn-sm">Update</button>
                </form>
              </div>
            </div>

            {{-- Price & Remove --}}
            <div class="text-right flex-shrink-0">
              <div class="px-price mb-2">${{ number_format($item->price, 2) }}</div>
              <div class="px-muted text-[.6rem] mb-3">x{{ $item->quantity }} = ${{ number_format($lineTotal, 2) }}</div>
              <form method="POST" action="{{ route('cart.remove', $item->product_id) }}">
                @csrf @method('DELETE')
                <button type="submit" class="px-btn px-btn-sm">REMOVE</button>
              </form>
            </div>
          </div>
        @endforeach
      </div>

      {{-- Cart Summary --}}
      <div class="px-cart-summary">
        <div class="flex items-center justify-between mb-6">
          <span class="px-card-title text-lg">TOTAL</span>
          <span class="px-price text-2xl">${{ number_format($items->sum(fn($i)=> $i->price * $i->quantity), 2) }}</span>
        </div>

        <div class="flex gap-3">
          <form method="POST" action="{{ route('cart.clear') }}" class="flex-1">
            @csrf @method('DELETE')
            <button type="submit" class="px-btn w-full">Clear Cart</button>
          </form>

          <form method="POST" action="{{ route('cart.checkout') }}" class="flex-1">
            @csrf
            <button type="submit" class="px-btn px-btn-primary w-full">Checkout</button>
          </form>
        </div>
      </div>
    </div>
  @endif
</div>
@endsection