@extends('layouts.admin')
@section('title', __('admin.edit_attribute'))

@section('content')
<div class="pagetitle">
    <h1>{{ __('admin.edit_attribute') }}</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.attributes.index') }}">{{ __('admin.attributes') }}</a></li>
            <li class="breadcrumb-item active">{{ __('admin.edit') }}</li>
        </ol>
    </nav>
</div>

<div class="card">
    <div class="card-body">
        <h5 class="card-title">{{ __('admin.attribute_details') }}</h5>

        <form method="POST" action="{{ route('admin.attributes.update', $attribute->id) }}">
            @csrf
            @method('PUT')

            {{-- Attribute Name --}}
            <div class="mb-3">
                <label for="name" class="form-label">{{ __('admin.attribute_name') }}</label>
                <input type="text" name="name" class="form-control" id="name" value="{{ old('name', $attribute->name) }}" required>
            </div>

            <hr>
            <div class="mb-3">
                <h5 class="card-title">{{ __('admin.assign_to_main_categories') }}</h5>
                <p class="text-muted small">{{ __('admin.select_categories_hint') }}</p>
                <div class="row">
                    @foreach ($categories as $category)
                        <div class="col-md-4">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="categories[]" value="{{ $category->id }}" id="cat-{{ $category->id }}"
                                    {{ in_array($category->id, old('categories', $attribute->categories->pluck('id')->toArray())) ? 'checked' : '' }}>
                                <label class="form-check-label" for="cat-{{ $category->id }}">
                                    {{ $category->name }}
                                </label>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="text-end">
                <a href="{{ route('admin.attributes.index') }}" class="btn btn-secondary">{{ __('admin.back') }}</a>
                <button type="submit" class="btn btn-warning">{{ __('admin.update_attribute') }}</button>
            </div>
        </form>
    </div>
</div>
@endsection