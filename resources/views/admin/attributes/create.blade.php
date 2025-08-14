@extends('layouts.admin')
@section('title', __('admin.add_new_attribute'))

@section('content')
<div class="pagetitle">
    <h1>{{ __('admin.add_new_attribute') }}</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.attributes.index') }}">{{ __('admin.attributes') }}</a></li>
            <li class="breadcrumb-item active">{{ __('admin.add_new') }}</li>
        </ol>
    </nav>
</div>

<div class="card">
    <div class="card-body">
        <h5 class="card-title">{{ __('admin.attribute_details') }}</h5>

        {{-- Display validation errors if any --}}
        @if ($errors->any())
        <div class="alert alert-danger">
            <ul>@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
        </div>
        @endif

        <form method="POST" action="{{ route('admin.attributes.store') }}">
            @csrf
            <div class="mb-3">
                <label for="name" class="form-label">{{ __('admin.attribute_name') }}</label>
                <input type="text" name="name" class="form-control" id="name" value="{{ old('name') }}" required>
            </div>
            <div class="mb-3">
                <label class="form-label fw-bold">{{ __('admin.assign_to_main_categories') }}</label>
                <p class="text-muted small">{{ __('admin.select_categories_hint') }}</p>
                <div class="row">
                    @foreach ($categories as $category)
                    <div class="col-md-4">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="categories[]" value="{{ $category->id }}" id="cat-{{ $category->id }}"
                                {{ (is_array(old('categories')) && in_array($category->id, old('categories'))) ? 'checked' : '' }}>
                            <label class="form-check-label" for="cat-{{ $category->id }}">{{ $category->name }}</label>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            <div class="text-end">
                <a href="{{ route('admin.attributes.index') }}" class="btn btn-secondary">{{ __('admin.back') }}</a>
                <button type="submit" class="btn btn-primary">{{ __('admin.save_attribute') }}</button>
            </div>
        </form>
    </div>
</div>
@endsection