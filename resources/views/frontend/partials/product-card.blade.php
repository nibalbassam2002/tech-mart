<div class="col-lg-4 col-md-6 mb-4">
    <div class="card h-100 product-card-pro">
        <div class="product-image-container">
            <a href="#"> {{-- Replace # with product detail URL --}}
                <img src="{{ $product->images instanceof \Illuminate\Support\Collection && $product->images->isNotEmpty() ? asset('storage/' . $product->images->first()->path) : asset('images/photo.jpg') }}"
                    class="card-img-top" alt="{{ $product->name }}">
            </a>
            <div class="product-actions">
                <a href="#" class="btn btn-icon" title="Add to Wishlist"><i class="bi bi-heart"></i></a>
                {{-- Add more actions if needed, e.g., quick view --}}
            </div>
            @if ($product->discount_price && $product->offer_ends_at > now())
                <span class="badge bg-danger product-badge">SALE</span>
            @endif
        </div>
        <div class="card-body pt-3 pb-2 px-3">
            <div class="product-category text-muted small mb-1">{{ $product->category->name ?? '' }}</div>
            <h5 class="card-title product-title"><a href="#" class="text-decoration-none">{{ $product->name }}</a>
            </h5>
            <div class="product-pricing mt-2">
                @if ($product->discount_price && $product->offer_ends_at > now())
                    <span class="discount-price fs-5 fw-bold">{{ $product->discount_price }}
                        {{ $product->currency }}</span>
                    <span class="original-price">{{ $product->price }} {{ $product->currency }}</span>
                @else
                    <span class="price fs-5 fw-bold">{{ $product->price }} {{ $product->currency }}</span>
                @endif
            </div>
        </div>
        <div class="card-footer bg-transparent border-top-0 pb-3 px-3">
            <a href="#" class="btn btn-primary w-100 add-to-cart-btn"><i class="bi bi-cart-plus"></i> Add to
                Cart</a>
        </div>
    </div>
</div>
