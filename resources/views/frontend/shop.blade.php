@extends('layouts.frontend')

@section('content')
    <div class="shop-page-wrapper container py-5">
        <div class="row">
            {{-- 1. Sidebar for Filters --}}
            <div class="col-lg-3">
                <aside class="shop-sidebar p-3 border rounded shadow-sm">
                    <h4 class="mb-4">Filter Products</h4>

                    {{-- Category Filters --}}
                    <div class="filter-section mb-4">
                        <h5 class="mb-3">Categories</h5>
                        <div class="list-group">
                            <a href="#" class="list-group-item list-group-item-action active"
                                data-filter-type="category" data-filter-value="all">All Categories</a>
                            <a href="#" class="list-group-item list-group-item-action" data-filter-type="category"
                                data-filter-value="mobiles"><i class="bi bi-phone me-2"></i>Mobile Phones</a>
                            <a href="#" class="list-group-item list-group-item-action" data-filter-type="category"
                                data-filter-value="headphones"><i class="bi bi-headphones me-2"></i>Headphones</a>
                            <a href="#" class="list-group-item list-group-item-action" data-filter-type="category"
                                data-filter-value="laptops"><i class="bi bi-laptop me-2"></i>Laptops</a>
                            <a href="#" class="list-group-item list-group-item-action" data-filter-type="category"
                                data-filter-value="playstations"><i class="bi bi-controller me-2"></i>Playstations</a>
                        </div>
                    </div>

                    {{-- Common Features Filters --}}
                    <div class="filter-section mb-4 common-filters">
                        <h5 class="mb-3">Price Range</h5>
                        {{-- Price Slider / Input --}}
                        <div class="range-slider">
                            <input type="range" class="form-range" min="0" max="10000" value="5000"
                                id="priceRange">
                            <p>Price: <span id="currentPriceValue">5000</span> SAR</p>
                        </div>
                    </div>

                    {{-- Category Specific Filters (Hidden initially, shown based on selected category) --}}
                    <div id="categorySpecificFilters" class="mb-4">
                        {{-- Filters for Mobiles --}}
                        <div class="filter-section specific-filter mobile-filters" style="display:none;"
                            data-category="mobiles">
                            <h5 class="mb-3">Mobile Features</h5>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="5g" id="feature5g">
                                <label class="form-check-label" for="feature5g">5G Connectivity</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="dual-sim" id="featureDualSim">
                                <label class="form-check-label" for="featureDualSim">Dual SIM</label>
                            </div>
                            {{-- More mobile specific filters --}}
                        </div>

                        {{-- Filters for Laptops --}}
                        <div class="filter-section specific-filter laptop-filters" style="display:none;"
                            data-category="laptops">
                            <h5 class="mb-3">Laptop Features</h5>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="ssd" id="featureSSD">
                                <label class="form-check-label" for="featureSSD">SSD Storage</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="touchscreen" id="featureTouchscreen">
                                <label class="form-check-label" for="featureTouchscreen">Touchscreen</label>
                            </div>
                            {{-- More laptop specific filters --}}
                        </div>

                        {{-- Filters for Headphones --}}
                        <div class="filter-section specific-filter headphone-filters" style="display:none;"
                            data-category="headphones">
                            <h5 class="mb-3">Headphone Features</h5>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="wireless" id="featureWireless">
                                <label class="form-check-label" for="featureWireless">Wireless</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="noise-cancelling"
                                    id="featureNoiseCancelling">
                                <label class="form-check-label" for="featureNoiseCancelling">Noise Cancelling</label>
                            </div>
                            {{-- More headphone specific filters --}}
                        </div>

                        {{-- Filters for Playstations --}}
                        <div class="filter-section specific-filter playstation-filters" style="display:none;"
                            data-category="playstations">
                            <h5 class="mb-3">Playstation Features</h5>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="new-gen" id="featureNewGen">
                                <label class="form-check-label" for="featureNewGen">New Generation</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="bundle" id="featureBundle">
                                <label class="form-check-label" for="featureBundle">Bundle Deals</label>
                            </div>
                            {{-- More playstation specific filters --}}
                        </div>
                    </div>

                    <button class="btn btn-primary w-100 mt-3" id="applyFiltersBtn">Apply Filters</button>
                    <button class="btn btn-outline-secondary w-100 mt-2" id="clearFiltersBtn">Clear Filters</button>

                </aside>
            </div>

            {{-- 2. Main Content Area for Products --}}
            <div class="col-lg-9">
                <div class="product-listing-header d-flex justify-content-between align-items-center mb-4">
                    <h3 class="mb-0" id="currentCategoryTitle">All Products</h3>
                    <div class="sort-options">
                        <label for="sortBy" class="me-2">Sort by:</label>
                        <select class="form-select d-inline-block w-auto" id="sortBy">
                            <option value="default">Default Sorting</option>
                            <option value="price_asc">Price: Low to High</option>
                            <option value="price_desc">Price: High to Low</option>
                            <option value="name_asc">Name: A to Z</option>
                            <option value="name_desc">Name: Z to A</option>
                        </select>
                    </div>
                </div>

                <div class="row g-4 product-grid">
                    @forelse($products as $product)
                        @include('frontend.partials.product-card', ['product' => $product])
                    @empty
                        <p class="text-center">No products to display.</p>
                    @endforelse
                </div>

                {{-- Pagination --}}
                <div class="d-flex justify-content-center mt-5">
                    <nav aria-label="Page navigation">
                        <ul class="pagination">
                            <li class="page-item disabled"><a class="page-link" href="#">Previous</a></li>
                            <li class="page-item active"><a class="page-link" href="#">1</a></li>
                            <li class="page-item"><a class="page-link" href="#">2</a></li>
                            <li class="page-item"><a class="page-link" href="#">3</a></li>
                            <li class="page-item"><a class="page-link" href="#">Next</a></li>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </div>

    {{-- Welcome & Discount Modal (Hidden by default, triggered by JS) --}}
    <div class="modal fade" id="welcomeDiscountModal" tabindex="-1" aria-labelledby="welcomeDiscountModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header border-0 pb-0">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-center px-4 pt-0">
                    <i class="bi bi-gift-fill text-primary display-3 mb-3"></i>
                    <h3 class="modal-title mb-3" id="welcomeDiscountModalLabel">Welcome to Tech-Mart!</h3>
                    <p class="lead">Enjoy an exclusive <span class="text-success fw-bold">10% OFF</span> on your first
                        purchase!</p>
                    <p>Use code: <strong class="text-primary fs-5">WELCOME10</strong> at checkout.</p>
                    <button type="button" class="btn btn-primary btn-lg mt-3" data-bs-dismiss="modal">Shop Now!</button>
                </div>
            </div>
        </div>
    </div>
@endsection
