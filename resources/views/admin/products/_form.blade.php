@php($isEdit = isset($product))
@csrf
@if($isEdit)
    @method('PUT')
@endif

<div class="admin-panel" style="margin-bottom:1.5rem;">
  <div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(220px,1fr));gap:1rem;">
    <div>
      <label class="px-label">Pokemon Name *</label>
      <input type="text" name="pokemon_name" class="admin-input" value="{{ old('pokemon_name', $product->pokemon_name ?? '') }}" required>
      @error('pokemon_name')<div class="px-error">{{ $message }}</div>@enderror
    </div>
    <div>
      <label class="px-label">Card Name</label>
      <input type="text" name="card_name" class="admin-input" value="{{ old('card_name', $product->card_name ?? '') }}">
      @error('card_name')<div class="px-error">{{ $message }}</div>@enderror
    </div>
    <div>
      <label class="px-label">Price *</label>
      <input type="number" step="0.01" name="price" class="admin-input" value="{{ old('price', $product->price ?? '') }}" required>
      @error('price')<div class="px-error">{{ $message }}</div>@enderror
    </div>
    <div>
      <label class="px-label">Stock *</label>
      <input type="number" name="stock" class="admin-input" value="{{ old('stock', $product->stock ?? '') }}" required>
      @error('stock')<div class="px-error">{{ $message }}</div>@enderror
    </div>
    <div>
      <label class="px-label">Category</label>
      <select name="category_id" class="admin-select">
        <option value="">-- None --</option>
        @foreach($categories as $cat)
          <option value="{{ $cat->id }}" @selected(old('category_id', $product->category_id ?? '') == $cat->id)>{{ $cat->name }}</option>
        @endforeach
      </select>
    </div>
    <div>
      <label class="px-label">Image URL</label>
      <input type="url" name="image_url" class="admin-input" value="{{ old('image_url', $product->image_url ?? '') }}">
    </div>
  </div>
</div>

<div class="admin-panel" style="margin-bottom:1.5rem;">
  <h3 class="admin-heading" style="margin-top:0;font-size:1.1rem;">Optional Metadata</h3>
  <div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(180px,1fr));gap:1rem;margin-top:1rem;">
    <div>
      <label class="px-label">Grader</label>
      <input type="text" name="grader" class="admin-input" value="{{ old('grader', $product->grader ?? '') }}">
    </div>
    <div>
      <label class="px-label">Grade</label>
      <input type="number" name="grade" class="admin-input" value="{{ old('grade', $product->grade ?? '') }}" min="0" max="10">
    </div>
    <div>
      <label class="px-label">Set Name</label>
      <input type="text" name="set_name" class="admin-input" value="{{ old('set_name', $product->set_name ?? '') }}">
    </div>
    <div>
      <label class="px-label">Card Number</label>
      <input type="text" name="card_number" class="admin-input" value="{{ old('card_number', $product->card_number ?? '') }}">
    </div>
    <div>
      <label class="px-label">Release Year</label>
      <input type="number" name="release_year" class="admin-input" value="{{ old('release_year', $product->release_year ?? '') }}" min="1900" max="2100">
    </div>
    <div>
      <label class="px-label">Edition</label>
      <input type="text" name="edition" class="admin-input" value="{{ old('edition', $product->edition ?? '') }}">
    </div>
    <div>
      <label class="px-label">Rarity</label>
      <input type="text" name="rarity" class="admin-input" value="{{ old('rarity', $product->rarity ?? '') }}">
    </div>
    <div>
      <label class="px-label">Holofoil Type</label>
      <input type="text" name="holofoil_type" class="admin-input" value="{{ old('holofoil_type', $product->holofoil_type ?? '') }}">
    </div>
    <div>
      <label class="px-label">Art Style</label>
      <input type="text" name="art_style" class="admin-input" value="{{ old('art_style', $product->art_style ?? '') }}">
    </div>
    <div>
      <label class="px-label">Artist Name</label>
      <input type="text" name="artist_name" class="admin-input" value="{{ old('artist_name', $product->artist_name ?? '') }}">
    </div>
    <div>
      <label class="px-label">Language</label>
      <input type="text" name="language" class="admin-input" value="{{ old('language', $product->language ?? '') }}">
    </div>
  </div>
  <div style="margin-top:1rem;">
    <label class="px-label">Collector Info</label>
    <textarea name="collector_info" rows="3" class="admin-textarea">{{ old('collector_info', $product->collector_info ?? '') }}</textarea>
  </div>
</div>

<div style="display:flex;gap:1rem;">
  <button class="px-btn px-btn-primary admin-btn">{{ $isEdit ? 'Update Product' : 'Create Product' }}</button>
  <a href="{{ route('admin.products.index') }}" class="px-btn btn-secondary admin-btn" style="text-decoration:none;display:inline-flex;align-items:center;">Cancel</a>
</div>
