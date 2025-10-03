@props(['product'])
<div class="px-card group cursor-pointer">
  <a href="{{ route('products.show', $product) }}" class="block space-y-3">
    <!-- Card Image -->
    <div class="relative">
      @php $img = $product->image_url ?: 'https://raw.githubusercontent.com/PokeAPI/sprites/master/sprites/pokemon/other/official-artwork/25.png'; @endphp
  <div class="px-card-image">
        <img src="{{ $img }}" 
             alt="{{ $product->card_name ?? $product->pokemon_name }}" 
             class="w-full h-full object-contain filter brightness-95 group-hover:brightness-110 transition-all duration-300">
      </div>
      
      <!-- Card ID Badge -->
      <div class="absolute top-2 left-2 text-xs font-mono">
        <div class="bg-black/80 border border-cyan-400/60 px-2 py-1 text-cyan-300 rounded">
          #{{ str_pad($product->id, 4, '0', STR_PAD_LEFT) }}
        </div>
      </div>
    </div>

    <!-- Card Information -->
    <div class="space-y-2">
      <!-- Card Name -->
  <h3 class="px-card-title group-hover:text-[var(--px-accent)] transition-colors duration-300">
        {{ $product->card_name ?? $product->pokemon_name }}
      </h3>
      
      <!-- Card Details -->
  <div class="space-y-1 text-[0.7rem] font-mono px-card-meta">
        @if($product->set_name)
          <div class="text-green-300/80">
            {{ $product->set_name }}
            @if($product->card_number)
              #{{ $product->card_number }}
            @endif
          </div>
        @endif
        
        @if($product->rarity)
          <div class="text-cyan-300/80">
            {{ ucfirst($product->rarity) }}
          </div>
        @endif
        
        @if($product->grader && $product->grade)
          <div class="text-cyan-300/80">
            {{ $product->grader }} {{ $product->grade }}
          </div>
        @endif
      </div>
      
      <!-- Price and Stock -->
      <div class="flex items-center justify-between mt-3 pt-3 border-t border-[#16354e]">
        <div class="px-price">
          ${{ number_format($product->price, 2) }}
        </div>
        <div class="text-[#88b9d3] text-[10px] font-mono tracking-wide">
          {{ $product->stock }} in stock
        </div>
      </div>
    </div>
  </a>

  <!-- Add to Cart Button -->
  <div class="mt-4">
    @auth
      <form method="POST" action="{{ route('cart.add', $product->id) }}" class="w-full">
        @csrf
        <button type="submit" class="px-btn px-btn-primary w-full">
          ADD
        </button>
      </form>
    @else
      <a href="{{ route('login') }}" class="px-btn w-full text-center">
        LOGIN
      </a>
    @endauth
  </div>
</div>
