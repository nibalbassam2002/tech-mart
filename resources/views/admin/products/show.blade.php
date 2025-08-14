@extends('layouts.admin')
@section('title', __('admin.product_details') . ': ' . $product->name)

@section('content')
<div class="pagetitle">
    <h1>{{ __('admin.product_details') }}</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.products.index') }}">{{ __('admin.products') }}</a></li>
            <li class="breadcrumb-item active">{{ __('admin.details') }}</li>
        </ol>
    </nav>
</div>

<section class="section product-details">
    <div class="row">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">{{ $product->name }}</h5>

                    <div class="mb-4">
                        <strong>{{ __('admin.category') }}:</strong>
                        {{ optional($product->category->parent)->name }} / {{ optional($product->category)->name }}
                    </div>

                    <div class="mb-4">
                        <strong>{{ __('admin.description') }}:</strong>
                        {!! $product->description !!}
                    </div>
                    
                    <hr>
                    <h5 class="card-title">{{ __('admin.attributes') }}</h5>
                    <dl class="row">
                        @forelse($product->attributeValues as $value)
                            <dt class="col-sm-3">{{ $value->attribute->name }}</dt>
                            <dd class="col-sm-9">{{ $value->value }}</dd>
                        @empty
                            <p class="text-muted">{{ __('admin.no_attributes_assigned') }}</p>
                        @endforelse
                    </dl>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">{{ __('admin.product_summary') }}</h5>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item d-flex justify-content-between">
                            <strong>{{ __('admin.price') }}:</strong>
                            <span>{{ number_format($product->price, 2) }} {{ $product->currency }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between">
                            <strong>{{ __('admin.quantity') }}:</strong>
                            <span>{{ $product->quantity }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between">
                            <strong>{{ __('admin.sku_id') }}:</strong>
                            <span>PROD-{{ $product->id }}</span>
                        </li>
                    </ul>
                    <div class="d-grid gap-2 mt-3">
                        <a href="{{ route('admin.products.edit', $product->id) }}" class="btn btn-warning">
                            <i class="bi bi-pencil"></i> {{ __('admin.edit_product') }}
                        </a>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">{{ __('admin.media_gallery') }}</h5>
                    <div class="row">
                        @forelse($product->images as $media)
                            <div class="col-6 mb-3">
                                @if($media->type == 'video')
                                    <video src="{{ asset('storage/' . $media->path) }}" class="img-fluid rounded" controls></video>
                                @else
                                    <img src="{{ asset('storage/' . $media->path) }}" class="img-fluid rounded">
                                @endif
                            </div>
                        @empty
                            <p class="text-muted">{{ __('admin.no_media_for_product') }}</p>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection