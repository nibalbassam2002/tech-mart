@extends('layouts.frontend')

@section('content')
    {{-- 1. Hero Section --}}
    <div class="hero-section-curved">
        <div class="container col-xxl-8 px-4">
            <div class="row align-items-center g-5">
                <div class="col-lg-6">
                    <h1 class="display-4 fw-bold mb-3" style="line-height: 1.2;">The Ultimate Shopping Destination</h1>
                    <p class="lead">Explore our curated collection of high-quality products, designed to fit your unique
                        lifestyle. Your satisfaction is our priority.</p>
                    <div class="d-grid gap-2 d-md-flex justify-content-md-start">
                        <a href="#latest-products" class="btn btn-primary btn-lg px-4 me-md-2 hero-btn">
                            Shop Now <i class="bi bi-arrow-right-short"></i>
                        </a>
                    </div>
                </div>
                <div class="col-10 col-sm-8 col-lg-6">
                    <img src="{{ asset('images/Credit.svg') }}" class="d-block mx-lg-auto img-fluid hero-image-float"
                        alt="Illustration">
                </div>
            </div>
        </div>
    </div>

    {{-- 2. Featured Categories Section --}}
    <div class="container px-4 py-5" id="featured-categories">
        <h2 class="pb-2 border-bottom text-center mb-5">Shop by Category</h2>
        <div class="row g-4 justify-content-center">
            @forelse($categories as $category)
                <div class="col-md-3">
                    <a href="#" class="text-decoration-none">
                        <div class="card text-center category-card h-100">
                            <div class="card-body d-flex flex-column align-items-center justify-content-center">
                                <div class="category-icon mb-3">
                                    @if (Str::contains(strtolower($category->name), 'mobile'))
                                        <i class="bi bi-phone fs-1"></i>
                                    @elseif(Str::contains(strtolower($category->name), 'laptop'))
                                        <i class="bi bi-laptop fs-1"></i>
                                    @elseif(Str::contains(strtolower($category->name), ['headphone', 'earphone']))
                                        <i class="bi bi-headphones fs-1"></i>
                                    @elseif(Str::contains(strtolower($category->name), 'playstation'))
                                        <i class="bi bi-controller fs-1"></i>
                                    @else
                                        <i class="bi bi-tag fs-1"></i>
                                    @endif
                                </div>
                                <h5 class="card-title">{{ $category->name }}</h5>
                            </div>
                        </div>
                    </a>
                </div>
            @empty
                <p class="text-center">No categories to display.</p>
            @endforelse
        </div>
    </div>

    {{-- 3. DYNAMIC & CREATIVE Offers Slider Section (FINAL) --}}
    @if ($featuredOffers->isNotEmpty())
        <div class.offer-section my-5>
            <div class="container">
                <h2 class="pb-2 border-bottom text-center mb-5">Don't Miss These Deals!</h2>
                <div id="offersCarousel" class="carousel slide" data-bs-ride="carousel">
                    <div class="carousel-inner">
                        @foreach ($featuredOffers as $index => $offer)
                            <div class="carousel-item {{ $index == 0 ? 'active' : '' }}">
                                <div class="offer-slide-content">
                                    <div class="offer-slide-bg" style="background-image: url('your-image.jpg')"></div>
                                    <img src="{{ $offer->images->first() ? asset('storage/' . $offer->images->first()->path) : asset('images/default-product-image.png') }}"
                                        class="offer-slide-image" alt="{{ $offer->name }}">
                                    <div class="offer-slide-overlay"></div>
                                    <div class="offer-slide-details">
                                        <h5 class="text-uppercase">Flash Sale!</h5>
                                        <h1>{{ $offer->name }}</h1>
                                        <div class="pricing">
                                            <span class="original-price">{{ $offer->price }} {{ $offer->currency }}</span>
                                            <span class="discount-price">{{ $offer->discount_price }}
                                                {{ $offer->currency }}</span>
                                        </div>
                                        <div class="countdown-container mt-4"
                                            data-countdown-date="{{ $offer->offer_ends_at }}">
                                            {{-- Countdown will be injected here --}}
                                        </div>
                                        <a href="#" class="btn btn-light btn-lg mt-4 hero-btn">Shop This Deal <i
                                                class="bi bi-arrow-right-short"></i></a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                </div>
            </div>
        </div>
    @endif

    {{-- 4. Latest Products Section --}}
    <div class="container px-4 py-5" id="latest-products">
        <h2 class="pb-2 border-bottom text-center mb-5">Our Latest Products</h2>
        <div class="row g-4 py-5">
            @forelse($latestProducts as $product)
                <div class="col-lg-3 col-md-4 col-sm-6">
                    <div class="card h-100 product-card-pro">
                        {{-- Image & Actions --}}
                        <div class="product-image-container">
                            <a href="#">
                                <img src="{{ $product->images->first() ? asset('storage/' . $product->images->first()->path) : asset('images/default-product-image.png') }}"
                                    class="card-img-top" alt="{{ $product->name }}">
                            </a>
                            <div class="product-actions">
                                <a href="#" class="btn btn-icon" title="Add to Wishlist"><i
                                        class="bi bi-heart"></i></a>
                                {{-- <a href="#" class="btn btn-icon" title="Compare"><i class="bi bi-arrow-left-right"></i></a> --}}
                            </div>
                            {{-- Discount Badge --}}
                            @if ($product->discount_price && $product->offer_ends_at > now())
                                <span class="badge bg-danger product-badge">SALE</span>
                            @endif
                        </div>

                        {{-- Card Body --}}
                        <div class="card-body pt-3 pb-2 px-3">
                            <div class="product-category text-muted small mb-1">
                                {{ $product->category->name ?? 'Uncategorized' }}</div>
                            <h5 class="card-title product-title">
                                <a href="#" class="text-decoration-none">{{ $product->name }}</a>
                            </h5>

                            {{-- We will add the rating system later --}}
                            {{-- <div class="product-rating mb-2"><i class="bi bi-star-fill"></i> 4.8 (25)</div> --}}

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

                        {{-- Card Footer with Add to Cart button --}}
                        <div class="card-footer bg-transparent border-top-0 pb-3 px-3">
                            <a href="#" class="btn btn-primary w-100 add-to-cart-btn"><i class="bi bi-cart-plus"></i>
                                Add to Cart</a>
                        </div>
                    </div>
                </div>
            @empty
                <p class="text-center">No products to display.</p>
            @endforelse
        </div>

        {{-- Button to view all products --}}
        <div class="text-center mt-4">
            <a href="#" class="btn btn-primary btn-lg hero-btn px-5">View All Products</a>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('.countdown-container').forEach(container => {
                const countDownDate = new Date(container.dataset.countdownDate).getTime();
                const countdownHtml = `
            <div class="countdown">
                <div class="countdown-item"><span>00</span><small>Days</small></div>
                <div class="countdown-item"><span>00</span><small>Hours</small></div>
                <div class="countdown-item"><span>00</span><small>Minutes</small></div>
                <div class="countdown-item"><span>00</span><small>Seconds</small></div>
            </div>`;
                container.innerHTML = countdownHtml;

                const timerId = setInterval(function() {
                    const now = new Date().getTime();
                    const distance = countDownDate - now;

                    if (distance < 0) {
                        clearInterval(timerId);
                        container.innerHTML = "<h5 class='text-white'>OFFER EXPIRED</h5>";
                        return;
                    }

                    const days = Math.floor(distance / (1000 * 60 * 60 * 24));
                    container.querySelector('.countdown-item:nth-child(1) span').innerText = String(
                        days).padStart(2, '0');

                    const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                    container.querySelector('.countdown-item:nth-child(2) span').innerText = String(
                        hours).padStart(2, '0');

                    const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                    container.querySelector('.countdown-item:nth-child(3) span').innerText = String(
                        minutes).padStart(2, '0');

                    const seconds = Math.floor((distance % (1000 * 60)) / 1000);
                    container.querySelector('.countdown-item:nth-child(4) span').innerText = String(
                        seconds).padStart(2, '0');

                }, 1000);
            });
        });
    </script>
@endsection
