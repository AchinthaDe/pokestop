@extends('admin.layout')

@section('admin-page', 'Products')
@section('admin-subtitle', 'Manage your product catalog')
@section('admin-content')
<div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:1.5rem;">
    <div>
        <span class="admin-muted" style="font-size:.75rem;text-transform:uppercase;letter-spacing:1px;">Total Products: {{ $products->total() }}</span>
    </div>
    <a href="{{ route('admin.products.create') }}" class="px-btn btn-primary admin-btn" style="font-size:.8rem;">+ Add New Product</a>
</div>
<div class="admin-panel">
    @if($products->isEmpty())
        <p class="admin-text admin-muted" style="text-align:center;padding:2rem;">No products.</p>
    @else
        <div style="overflow-x:auto;">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th style="width:70px;">Image</th>
                        <th>Product</th>
                        <th>Category</th>
                        <th>Price</th>
                        <th>Stock</th>
                        <th style="text-align:center;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($products as $product)
                        <tr>
                            <td>
                                @if($product->image_url)
                                    <img src="{{ $product->image_url }}" alt="{{ $product->pokemon_name }}" style="width:54px;height:54px;object-fit:contain;border:1px solid var(--px-border);border-radius:4px;background:#fff;" />
                                @else
                                    <div style="width:54px;height:54px;border:1px solid var(--px-border);border-radius:4px;display:flex;align-items:center;justify-content:center;font-size:.55rem;" class="admin-muted">No Img</div>
                                @endif
                            </td>
                            <td>
                                <strong>{{ $product->pokemon_name ?? $product->card_name }}</strong>
                                @if($product->card_name && $product->pokemon_name)
                                    <div class="admin-muted" style="font-size:.6rem;">{{ $product->card_name }}</div>
                                @endif
                            </td>
                            <td>{{ $product->category->name ?? 'N/A' }}</td>
                            <td><strong class="px-text-primary">${{ number_format($product->price,2) }}</strong></td>
                            <td>
                                <span style="color:{{ $product->stock <=5 ? 'var(--px-danger)' : ($product->stock <=10 ? 'var(--px-yellow)' : 'var(--px-green)') }};font-weight:600;">{{ $product->stock }}</span>
                            </td>
                            <td style="text-align:center;">
                                <a href="{{ route('admin.products.edit',$product) }}" class="px-btn btn-primary admin-btn-sm">Edit</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div style="margin-top:1rem;">{{ $products->links() }}</div>
    @endif
</div>
@endsection
