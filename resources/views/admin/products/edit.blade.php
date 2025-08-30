@extends('layouts.admin')
@section('title', __('admin.edit_product') . ': ' . $product->name)

@section('content')
    <div class="pagetitle">
        <h1>{{ __('admin.edit_product') }}</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('admin.products.index') }}">{{ __('admin.products') }}</a></li>
                <li class="breadcrumb-item active">{{ __('admin.edit') }}</li>
            </ol>
        </nav>
    </div>

    <div class="card">
        <div class="card-body">
            <h5 class="card-title">{{ __('admin.editing') }}: {{ $product->name }}</h5>

            @if (session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('admin.products.update', $product->id) }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="row">
                    <div class="col-md-8">
                        <div class="mb-3">
                            <label for="name" class="form-label required-field">{{ __('admin.product_name') }}</label>
                            <input type="text" name="name" class="form-control"
                                value="{{ old('name', $product->name) }}" required>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="main_category"
                                    class="form-label required-field">{{ __('admin.main_category') }}</label>
                                <select id="main_category" class="form-select" required>
                                    <option value="">-- {{ __('admin.select') }} --</option>
                                    @foreach ($mainCategories as $cat)
                                        <option value="{{ $cat->id }}"
                                            {{ old('main_category', optional($mainCategory)->id) == $cat->id ? 'selected' : '' }}>
                                            {{ $cat->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="category_id"
                                    class="form-label required-field">{{ __('admin.sub_category') }}</label>
                                <select name="category_id" id="category_id" class="form-select" required>
                                    <option value="">-- {{ __('admin.select_main_category_first') }} --</option>
                                </select>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="description" class="form-label">{{ __('admin.description') }}</label>
                            <textarea name="description" class="form-control tinymce-editor" rows="6">{{ old('description', $product->description) }}</textarea>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label for="price" class="form-label required-field">{{ __('admin.price') }}</label>
                            <div class="input-group">
                                <input type="number" name="price" class="form-control"
                                    value="{{ old('price', $product->price) }}" step="0.01" required>
                                <select name="currency" class="form-select" style="max-width: 100px;">
                                    <option value="SAR"
                                        {{ old('currency', $product->currency) == 'SAR' ? 'selected' : '' }}>SAR</option>
                                    <option value="USD"
                                        {{ old('currency', $product->currency) == 'USD' ? 'selected' : '' }}>USD</option>
                                    <option value="JOD"
                                        {{ old('currency', $product->currency) == 'JOD' ? 'selected' : '' }}>JOD</option>
                                </select>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="quantity" class="form-label required-field">{{ __('admin.quantity') }}</label>
                            <input type="number" name="quantity" class="form-control"
                                value="{{ old('quantity', $product->quantity) }}" required>
                        </div>
                    </div>
                </div>

                <hr>
                <h5 class="card-title">{{ __('admin.product_attributes') }}</h5>
                <div id="attributes-container" class="p-3 border rounded bg-light">
                    <p class="text-muted text-center">{{ __('admin.loading') }}</p>
                </div>

                <hr>
                <h5 class="card-title">{{ __('admin.manage_media') }}</h5>
                <div class="mb-3">
                    <label for="images" class="form-label">{{ __('admin.add_more_media') }}</label>
                    <input class="form-control" type="file" id="images" name="images[]" multiple accept="image/*">
                </div>
                <div class="row" id="media-gallery">
                    @forelse($product->images as $media)
                        <div class="col-md-3 text-center position-relative mb-3" id="media-container-{{ $media->id }}">
                            @if ($media->type == 'video')
                                <video width="100%" class="img-fluid rounded border" controls>
                                    <source src="{{ asset('storage/' . $media->path) }}" type="video/mp4">
                                </video>
                            @else
                                <img src="{{ asset('storage/' . $media->path) }}" class="img-fluid rounded border">
                            @endif
                            <button type="button"
                                class="btn btn-sm btn-danger position-absolute top-0 end-0 m-1 delete-media-btn"
                                data-media-id="{{ $media->id }}"><i class="bi bi-x-lg"></i></button>
                        </div>
                    @empty
                        <p id="no-media-text" class="text-muted">{{ __('admin.no_media_uploaded') }}</p>
                    @endforelse
                </div>
                {{-- Discount Price --}}
                <div class="mb-3">
                    <label for="discount_price" class="form-label">Discount Price (Optional)</label>
                    <input type="number" name="discount_price" class="form-control" step="0.01">
                </div>

                {{-- Offer End Date --}}
                <div class="mb-3">
                    <label for="offer_ends_at" class="form-label">Offer Ends At (Optional)</label>
                    <input type="datetime-local" name="offer_ends_at" class="form-control">
                </div>
                <div class="text-end mt-4">
                    <a href="{{ route('admin.products.index') }}" class="btn btn-secondary">{{ __('admin.cancel') }}</a>
                    <button type="submit" class="btn btn-warning">{{ __('admin.update_product') }}</button>
                </div>

            </form>
        </div>
    </div>
@endsection

@push('scripts')
    {{-- JavaScript for cascading dropdowns, attributes, and media deletion --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const mainCategorySelect = document.getElementById('main_category');
            const subCategorySelect = document.getElementById('category_id');
            const attributesContainer = document.getElementById('attributes-container');

            // The sub-category ID that is currently saved for this product
            const initialSubCategoryId = '{{ old('category_id', $product->category_id) }}';

            // ▼▼▼ THIS IS THE FULL, CORRECT CODE FOR THE FUNCTION ▼▼▼
            function fetchSubcategories(mainCatId, selectedSubCatId = null) {
                if (!mainCatId) {
                    subCategorySelect.innerHTML = '<option value="">-- Select Main Category First --</option>';
                    subCategorySelect.disabled = true;
                    return;
                }
                subCategorySelect.innerHTML = '<option value="">Loading...</option>';
                subCategorySelect.disabled = true;

                fetch(`/admin/get-subcategories/${mainCatId}`)
                    .then(response => {
                        if (!response.ok) throw new Error('Network response was not ok');
                        return response.json();
                    })
                    .then(data => {
                        let options = '<option value="">-- Select Sub-Category --</option>';
                        data.forEach(sub => {
                            const isSelected = sub.id == selectedSubCatId ? 'selected' : '';
                            options += `<option value="${sub.id}" ${isSelected}>${sub.name}</option>`;
                        });
                        subCategorySelect.innerHTML = options;
                        subCategorySelect.disabled = false;

                        if (selectedSubCatId) {
                            subCategorySelect.dispatchEvent(new Event('change'));
                        }
                    })
                    .catch(error => {
                        console.error('Error fetching subcategories:', error);
                        subCategorySelect.innerHTML = '<option value="">Failed to load</option>';
                    });
            }

            // ▼▼▼ THIS IS THE FULL, CORRECT CODE FOR THE FUNCTION ▼▼▼
            function fetchAttributes(subCatId) {
                if (!subCatId) {
                    attributesContainer.innerHTML =
                        '<p class="text-muted text-center">Select a sub-category to see its attributes.</p>';
                    return;
                }
                attributesContainer.innerHTML = '<p class="text-muted text-center">Loading attributes...</p>';

                fetch(`/admin/get-attributes/${subCatId}`)
                    .then(response => {
                        if (!response.ok) throw new Error('Network response was not ok');
                        return response.json();
                    })
                    .then(data => {
                        attributesContainer.innerHTML = '';
                        // Get an array of the IDs of the attribute values already associated with this product
                        const currentAttributeValues = {!! json_encode($product->attributeValues->pluck('id')->toArray()) !!};

                        if (data.length === 0) {
                            attributesContainer.innerHTML =
                                '<p class="text-muted text-center">No attributes found for this category.</p>';
                        } else {
                            data.forEach(attr => {
                                let options = '';
                                attr.values.forEach(val => {
                                    // Check if the current value's ID is in the product's associated values
                                    const isSelected = currentAttributeValues.includes(val.id) ?
                                        'selected' : '';
                                    options +=
                                        `<option value="${val.id}" ${isSelected}>${val.value}</option>`;
                                });
                                const attrHtml = `
                            <div class="row mb-3 align-items-center">
                                <div class="col-md-3"><label class="form-label">${attr.name}</label></div>
                                <div class="col-md-9">
                                    <select name="attributes[${attr.id}][]" class="form-select" multiple>${options}</select>
                                    <small class="text-muted">Hold Ctrl (or Cmd on Mac) to select multiple values.</small>
                                </div>
                            </div>`;
                                attributesContainer.innerHTML += attrHtml;
                            });
                        }
                    })
                    .catch(error => {
                        console.error('Error fetching attributes:', error);
                        attributesContainer.innerHTML =
                            '<p class="text-danger text-center">Failed to load attributes.</p>';
                    });
            }

            // Event listeners for user interaction
            mainCategorySelect.addEventListener('change', () => fetchSubcategories(mainCategorySelect.value));
            subCategorySelect.addEventListener('change', () => fetchAttributes(subCategorySelect.value));

            // Initial load when the page is ready
            if (mainCategorySelect.value) {
                fetchSubcategories(mainCategorySelect.value, initialSubCategoryId);
            }

            // Logic for deleting media (This part is correct)
            const mediaGallery = document.getElementById('media-gallery');
            mediaGallery.addEventListener('click', function(event) {
                if (event.target.closest('.delete-media-btn')) {
                    const button = event.target.closest('.delete-media-btn');
                    const mediaId = button.dataset.mediaId;

                    Swal.fire({
                        title: 'Are you sure?',
                        text: "This action cannot be undone!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#d33',
                        cancelButtonColor: '#3085d6',
                        confirmButtonText: 'Yes, delete it!'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            fetch(`/admin/product-images/${mediaId}`, {
                                    method: 'DELETE',
                                    headers: {
                                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                        'Accept': 'application/json',
                                    }
                                })
                                .then(response => response.json())
                                .then(data => {
                                    if (data.success) {
                                        document.getElementById(`media-container-${mediaId}`)
                                            .remove();
                                    }
                                });
                        }
                    })
                }
            });
        });
    </script>
@endpush
