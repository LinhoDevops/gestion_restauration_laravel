<!-- components/product-card.blade.php -->
<div class="card product-card shadow rounded overflow-hidden">
    <div class="position-relative">
        <img class="img-fluid w-100 object-fit-cover" style="max-height: 250px;" src="{{ $product->image_url }}" alt="{{ $product->name }}">
        <small class="position-absolute start-0 top-100 translate-middle-y bg-burger text-white rounded py-1 px-3 ms-4">{{ number_format($product->price, 0, ',', ' ') }} FCFA</small>
    </div>
    <div class="p-4 mt-2">
        <div class="d-flex justify-content-between mb-3">
            <h5 class="mb-0">{{ $product->name }}</h5>
            <div class="ps-2">
                @if($product->stock > 0)
                    <span class="badge bg-success">En stock</span>
                @else
                    <span class="badge bg-danger">Indisponible</span>
                @endif
            </div>
        </div>
        <p class="text-body mb-3">{{ Str::limit($product->description, 100) }}</p>
        <div class="d-flex justify-content-between">
            <a class="btn btn-sm btn-burger rounded py-2 px-4" href="{{ route('client.product.show', $product->id) }}">Détails</a>
{{--            @if($product->stock > 0)--}}
{{--                <form action="{{ route('client.cart.add') }}" method="POST">--}}
{{--                    @csrf--}}
{{--                    <input type="hidden" name="product_id" value="{{ $product->id }}">--}}
{{--                    <button type="submit" class="btn btn-sm btn-dark rounded py-2 px-4">Ajouter au panier</button>--}}
{{--                </form>--}}
{{--            @endif--}}
        </div>
    </div>
</div>
