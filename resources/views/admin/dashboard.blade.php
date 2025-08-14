@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')

<div class="pagetitle">
    <h1>{{ __('admin.dashboard') }}</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">{{ __('admin.home') }}</a></li>
            <li class="breadcrumb-item active">{{ __('admin.dashboard') }}</li>
        </ol>
    </nav>
</div><!-- End Page Title -->

<section class="section dashboard">
    <div class="row">

        <!-- Left side columns -->
        <div class="col-lg-8">
            <div class="row">

                <!-- Products Card -->
                <div class="col-xxl-4 col-md-6">
                    <div class="card info-card sales-card">
                        <div class="card-body">
                            <h5 class="card-title">{{ __('admin.products') }}</h5>
                            <div class="d-flex align-items-center">
                                <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                    <i class="bi bi-box-seam"></i>
                                </div>
                                <div class="ps-3"><h6>{{ $totalProducts }}</h6></div>
                            </div>
                        </div>
                    </div>
                </div><!-- End Products Card -->

                <!-- Categories Card -->
                <div class="col-xxl-4 col-md-6">
                    <div class="card info-card revenue-card">
                        <div class="card-body">
                            <h5 class="card-title">{{ __('admin.main_categories') }}</h5>
                            <div class="d-flex align-items-center">
                                <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                    <i class="bi bi-tag"></i>
                                </div>
                                <div class="ps-3"><h6>{{ $totalCategories }}</h6></div>
                            </div>
                        </div>
                    </div>
                </div><!-- End Categories Card -->

                <!-- Customers Card -->
                <div class="col-xxl-4 col-xl-12">
                    <div class="card info-card customers-card">
                        <div class="card-body">
                            <h5 class="card-title">{{ __('admin.customers') }}</h5>
                            <div class="d-flex align-items-center">
                                <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                    <i class="bi bi-people"></i>
                                </div>
                                <div class="ps-3"><h6>{{ $totalCustomers }}</h6></div>
                            </div>
                        </div>
                    </div>
                </div><!-- End Customers Card -->
                
                <!-- Recent Products -->
                <div class="col-12">
                    <div class="card recent-sales overflow-auto">
                        <div class="card-body">
                            <h5 class="card-title">{{ __('admin.recent_products') }}</h5>
                            <table class="table table-borderless">
                                <thead>
                                    <tr>
                                        <th scope="col">{{ __('admin.image') }}</th>
                                        <th scope="col">{{ __('admin.product') }}</th>
                                        <th scope="col">{{ __('admin.price') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($recentProducts as $product)
                                    <tr>
                                        <th scope="row">
                                            <a href="{{ route('admin.products.show', $product->id) }}">
                                                @if($product->images->isNotEmpty())
                                                    <img src="{{ asset('storage/' . $product->images->first()->path) }}" alt="" style="width: 40px; height: 40px; object-fit: cover;">
                                                @else
                                                    <img src="{{ asset('images/default-product-image.png') }}" alt="" style="width: 40px;">
                                                @endif
                                            </a>
                                        </th>
                                        <td><a href="{{ route('admin.products.show', $product->id) }}" class="text-primary fw-bold">{{ $product->name }}</a></td>
                                        <td>{{ number_format($product->price) }} {{ $product->currency }}</td>
                                    </tr>
                                    @empty
                                    <tr><td colspan="3" class="text-center">No products yet.</td></tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div><!-- End Recent Products -->

            </div>
        </div><!-- End Left side columns -->

        <!-- Right side columns -->
        <div class="col-lg-4">
            <!-- Recent Customers -->
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">{{ __('admin.recent_customers') }}</h5>
                    <div class="activity">
                        @forelse($recentCustomers as $customer)
                        <div class="activity-item d-flex">
                            <div class="activite-label">{{ $customer->created_at->diffForHumans() }}</div>
                            <i class='bi bi-circle-fill activity-badge text-success align-self-start'></i>
                            <div class="activity-content">
                                {{ $customer->name }} just registered.
                            </div>
                        </div>
                        @empty
                        <p class="text-center text-muted">{{ __('admin.no_customers_yet') }}</p>
                        @endforelse
                    </div>
                </div>
            </div><!-- End Recent Customers -->
        </div><!-- End Right side columns -->

    </div>
</section>

@endsection