<div class="flex flex-col lg:flex-row gap-14">
  {{-- FILTER PANEL --}}
  <aside class="w-full lg:w-80 xl:w-96 lg:sticky top-8 self-start">
    <div class="px-panel">
      <h3 class="px-card-title mb-4">Filters</h3>
      {{-- Search --}}
      <div class="px-field">
        <label class="px-label">Search</label>
        <input wire:model.live.debounce.300ms="q" type="text" class="px-input" placeholder="pokemon or card name" />
      </div>

    {{-- Category Filter --}}
    @if(!empty($categories))
      <div class="px-field">
        <label class="px-label">Series</label>
        <select wire:model.live="category" class="px-input">
          <option value="">All</option>
          @foreach($categories as $c)
            <option value="{{ $c['id'] }}">{{ $c['name'] }}</option>
          @endforeach
        </select>
      </div>
    @endif

    {{-- Set Name Filter --}}
    @if(!empty($set_names))
      <div class="px-field">
        <label class="px-label">Set</label>
        <select wire:model.live="set_name" class="px-input">
          <option value="">All</option>
          @foreach($set_names as $s)
            <option value="{{ $s }}">{{ $s }}</option>
          @endforeach
        </select>
      </div>
    @endif

    {{-- Grading Section --}}
  <div class="grid grid-cols-2 gap-3">
      @if(!empty($graders))
        <div>
          <label class="px-label">Grader</label>
          <select wire:model.live="grader" class="px-input">
            <option value="">Any</option>
            @foreach($graders as $g)
              <option value="{{ $g }}">{{ $g }}</option>
            @endforeach
          </select>
        </div>
      @endif

      @if(!empty($grades))
        <div>
          <label class="px-label">Grade</label>
          <select wire:model.live="grade" class="px-input">
            <option value="">Any</option>
            @foreach($grades as $gr)
              <option value="{{ $gr }}">{{ $gr }}</option>
            @endforeach
          </select>
        </div>
      @endif
    </div>

    {{-- Card Details Section --}}
  <div class="grid grid-cols-2 gap-3 mt-2">
      @if(!empty($release_years))
        <div>
          <label class="px-label">Year</label>
          <select wire:model.live="release_year" class="px-input">
            <option value="">Any</option>
            @foreach($release_years as $y)
              <option value="{{ $y }}">{{ $y }}</option>
            @endforeach
          </select>
        </div>
      @endif

      @if(!empty($editions))
        <div>
          <label class="px-label">Edition</label>
          <select wire:model.live="edition" class="px-input">
            <option value="">Any</option>
            @foreach($editions as $e)
              <option value="{{ $e }}">{{ $e }}</option>
            @endforeach
          </select>
        </div>
      @endif
    </div>

    {{-- Rarity & Holofoil Section --}}
  <div class="grid grid-cols-2 gap-3 mt-2">
      @if(!empty($rarities))
        <div>
          <label class="px-label">Rarity</label>
          <select wire:model.live="rarity" class="px-input">
            <option value="">Any</option>
            @foreach($rarities as $r)
              <option value="{{ $r }}">{{ $r }}</option>
            @endforeach
          </select>
        </div>
      @endif

      @if(!empty($holofoil_types))
        <div>
          <label class="px-label">Holofoil</label>
          <select wire:model.live="holofoil_type" class="px-input">
            <option value="">Any</option>
            @foreach($holofoil_types as $h)
              <option value="{{ $h }}">{{ $h }}</option>
            @endforeach
          </select>
        </div>
      @endif
    </div>

    {{-- Style & Language Section --}}
  <div class="grid grid-cols-2 gap-3 mt-2">
      @if(!empty($art_styles))
        <div>
          <label class="px-label">Art Style</label>
          <select wire:model.live="art_style" class="px-input">
            <option value="">Any</option>
            @foreach($art_styles as $a)
              <option value="{{ $a }}">{{ $a }}</option>
            @endforeach
          </select>
        </div>
      @endif

      @if(!empty($languages))
        <div>
          <label class="px-label">Language</label>
          <select wire:model.live="language" class="px-input">
            <option value="">Any</option>
            @foreach($languages as $l)
              <option value="{{ $l }}">{{ $l }}</option>
            @endforeach
          </select>
        </div>
      @endif
    </div>

    {{-- Price Range Section --}}
    <div class="px-field">
      <label class="px-label">Price ($)</label>
      <div class="flex gap-2">
        <input wire:model.live.debounce.500ms="min_price" type="number" step="0.01" class="px-input" placeholder="Min" />
        <input wire:model.live.debounce.500ms="max_price" type="number" step="0.01" class="px-input" placeholder="Max" />
      </div>
      <div class="px-muted mt-1 text-xs tracking-wide">Range: ${{ number_format($global_min_price, 2) }} - ${{ number_format($global_max_price, 2) }}</div>
    </div>

    {{-- Reset Terminal --}}
    <div class="mt-6 flex gap-2">
      <button wire:click="resetFilters" type="button" class="px-btn flex-1">Reset</button>
    </div>

    {{-- Terminal Debug Monitor --}}
    <div class="mt-6 text-[.55rem] tracking-[1px] leading-3 px-muted">
      RESULTS: {{ $products->total() }}
    </div>
    </div>
  </aside>

  {{-- RESULTS --}}
  <div class="flex-1">
    @if($products->count() === 0)
      <div class="px-card px-center">
        No cards match filters.
      </div>
    @else
      <div class="px-grid px-grid-3">
        @foreach($products as $product)
          <x-product-card :product="$product" />
        @endforeach
      </div>
      <div class="mt-6">
        {{ $products->links() }}
      </div>
    @endif
  </div>
</div>