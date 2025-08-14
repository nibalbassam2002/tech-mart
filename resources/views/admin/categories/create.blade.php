@extends('layouts.admin')
@section('title', __('admin.add_new_category'))

@section('content')
<div class="pagetitle">
    <h1>{{ __('admin.add_new_category') }}</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.categories.index') }}">{{ __('admin.categories') }}</a></li>
            <li class="breadcrumb-item active">{{ __('admin.add_new') }}</li>
        </ol>
    </nav>
</div><!-- End Page Title -->

<div class="row">
    <div class="col-lg-8 mx-auto">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">{{ __('admin.category_details') }}</h5>

                @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
                </div>
                @endif

                <form method="POST" action="{{ route('admin.categories.store') }}">
                    @csrf
                    <div class="mb-3">
                        <label for="name" class="form-label required-field">{{ __('admin.category_name') }}</label>
                        <input type="text" name="name" class="form-control" id="name" value="{{ old('name') }}" required>
                    </div>
                    <div class="mb-3">
                        <label for="parent_id" class="form-label">{{ __('admin.parent_category') }}</label>
                        <select name="parent_id" id="parent_id" class="form-select">
                            <option value="">{{ __('admin.none_main_category') }}</option>
                            @foreach ($parentCategories as $parent)
                                <option value="{{ $parent->id }}" {{ old('parent_id') == $parent->id ? 'selected' : '' }}>{{ $parent->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="text-end">
                        <a href="{{ route('admin.categories.index') }}" class="btn btn-secondary">{{ __('admin.back') }}</a>
                        <button type="submit" class="btn btn-primary">{{ __('admin.save_category') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        $('#parent_id').select2({
            theme: "bootstrap-5",
            dropdownParent: $('#parent_id').parent()
        });
    });
</script>
@endpush