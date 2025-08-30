@extends('layouts.admin')
@section('title', __('admin.add_new_product'))

@section('content')
    <div class="pagetitle">
        <h1>{{ __('admin.add_new_product') }}</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('admin.products.index') }}">{{ __('admin.products') }}</a></li>
                <li class="breadcrumb-item active">{{ __('admin.add_new') }}</li>
            </ol>
        </nav>
    </div>

    <div class="card">
        <div class="card-body">
            <h5 class="card-title">{{ __('admin.product_information') }}</h5>

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

            <form method="POST" action="{{ route('admin.products.store') }}" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-md-8">
                        <div class="mb-3">
                            <label for="name" class="form-label required-field">{{ __('admin.product_name') }}</label>
                            <input type="text" name="name" class="form-control" value="{{ old('name') }}" required>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="main_category"
                                    class="form-label required-field">{{ __('admin.main_categories') }}</label>
                                <select id="main_category" class="form-select" required>
                                    <option value="">-- {{ __('admin.select') }} --</option>
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}"
                                            {{ old('main_category') == $category->id ? 'selected' : '' }}>
                                            {{ $category->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="category_id"
                                    class="form-label required-field">{{ __('admin.sub_categories') }}</label>
                                <select name="category_id" id="category_id" class="form-select" required disabled>
                                    <option value="">-- {{ __('admin.select_main_category_first') }} --</option>
                                </select>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="description" class="form-label">{{ __('admin.description') }}</label>
                            <textarea name="description" class="form-control tinymce-editor" rows="6">{{ old('description') }}</textarea>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label for="price" class="form-label required-field">{{ __('admin.price') }}</label>
                            <div class="input-group">
                                <input type="number" name="price" class="form-control" value="{{ old('price') }}"
                                    step="0.01" required>
                                <select name="currency" class="form-select" style="max-width: 100px;">
                                    <option value="SAR" selected>SAR</option>
                                    <option value="USD">USD</option>
                                    <option value="JOD">JOD</option>
                                </select>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="quantity" class="form-label required-field">{{ __('admin.quantity') }}</label>
                            <input type="number" name="quantity" class="form-control" value="{{ old('quantity') }}"
                                required>
                        </div>
                        <div class="mb-3">
                            <label for="images" class="form-label">{{ __('admin.product_media') }}</label>
                            <input class="form-control" type="file" id="images" name="images[]" multiple
                                accept="image/*">
                            <small class="text-muted">{{ __('admin.select_multiple_images') }}</small>
                        </div>
                    </div>
                </div>
                <hr>
                <h5 class="card-title">{{ __('admin.product_attributes') }}</h5>
                <div id="attributes-container" class="p-3 border rounded bg-light">
                    <p class="text-muted text-center">{{ __('admin.select_subcategory_to_load') }}</p>
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
                    <button type="submit" class="btn btn-primary">{{ __('admin.save_product') }}</button>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            // --- Initialize Select2 on page load ---
            $('#main_category').select2({
                theme: "bootstrap-5"
            });
            $('#category_id').select2({
                theme: "bootstrap-5"
            });

            // --- Logic for Main Category Change ---
            $('#main_category').on('change', function() {
                const mainCatId = $(this).val();
                const subCategorySelect = $('#category_id');
                const attributesContainer = $('#attributes-container');

                // Reset sub-category and attributes
                subCategorySelect.html(
                        '<option value="">-- {{ __('admin.select_main_category_first') }} --</option>')
                    .prop('disabled', true);
                attributesContainer.html(
                    `<p class="text-muted text-center">{{ __('admin.select_subcategory_to_load') }}</p>`
                );

                if (!mainCatId) {
                    subCategorySelect.select2({
                        theme: "bootstrap-5"
                    }); // Re-apply select2 to show placeholder
                    return;
                }

                subCategorySelect.html('<option value="">{{ __('admin.loading') }}</option>');

                // --- AJAX call to get sub-categories ---
                $.ajax({
                    url: `/admin/get-subcategories/${mainCatId}`,
                    type: 'GET',
                    success: function(data) {
                        let options =
                            '<option value="">-- {{ __('admin.select_subcategory') }} --</option>';
                        data.forEach(sub => {
                            options += `<option value="${sub.id}">${sub.name}</option>`;
                        });
                        subCategorySelect.html(options).prop('disabled', false);
                        // CRITICAL: Re-initialize Select2 on the updated element
                        subCategorySelect.select2({
                            theme: "bootstrap-5"
                        });
                    },
                    error: function() {
                        console.error('Failed to load sub-categories.');
                        subCategorySelect.html('<option value="">Failed to load</option>');
                    }
                });
            });

            // --- Logic for Sub-Category Change ---
            $('#category_id').on('change', function() {
                const subCatId = $(this).val();
                const attributesContainer = $('#attributes-container');

                if (!subCatId) {
                    attributesContainer.html(
                        `<p class="text-muted text-center">{{ __('admin.select_subcategory_to_load') }}</p>`
                    );
                    return;
                }

                attributesContainer.html(
                    `<p class="text-muted text-center">{{ __('admin.loading') }}</p>`);

                // --- AJAX call to get attributes ---
                $.ajax({
                    url: `/admin/get-attributes/${subCatId}`,
                    type: 'GET',
                    success: function(data) {
                        attributesContainer.html('');
                        if (data.length === 0) {
                            attributesContainer.html(
                                `<p class="text-muted text-center">{{ __('admin.no_attributes_for_category') }}</p>`
                            );
                        } else {
                            data.forEach(attr => {
                                let options = '';
                                attr.values.forEach(val => {
                                    options +=
                                        `<option value="${val.id}">${val.value}</option>`;
                                });
                                const attrHtml = `
                            <div class="row mb-3 align-items-center">
                                <div class="col-md-3"><label class="form-label">${attr.name}</label></div>
                                <div class="col-md-9">
                                    <select name="attributes[${attr.id}][]" class="form-select" multiple>${options}</select>
                                    <small class="text-muted">{{ __('admin.select_multiple_values_hint') }}</small>
                                </div>
                            </div>`;
                                attributesContainer.append(attrHtml);
                            });
                        }
                    },
                    error: function() {
                        console.error('Failed to load attributes.');
                        attributesContainer.html(
                            '<p class="text-danger text-center">Failed to load attributes.</p>'
                        );
                    }
                });
            });
        });
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {

            // تعريف الدالة التي تقوم بتفعيل TinyMCE
            function initializeTinyMCE() {
                // أولاً، قم بإزالة أي محرر قديم لتجنب التكرار والأخطاء
                tinymce.remove('textarea.tinymce-editor');

                // ثانياً، قم بتفعيل المحرر من جديد بالإعدادات الصحيحة
                tinymce.init({
                    selector: 'textarea.tinymce-editor', // استهداف الكلاس بدلاً من الـ ID
                    promotion: false, // لإخفاء رسالة الترقية
                    skin: document.documentElement.classList.contains('dark-mode') ? 'oxide-dark' : 'oxide',
                    content_css: document.documentElement.classList.contains('dark-mode') ? 'dark' :
                        'default',
                    setup: function(editor) {
                        // التأكد من لون النص عند التركيز في الوضع المظلم
                        editor.on('focus', function(e) {
                            if (document.documentElement.classList.contains('dark-mode')) {
                                editor.getBody().style.color = '#c9d1d9';
                            }
                        });
                    }
                });
            }

            // قم بتفعيل المحرر عند تحميل الصفحة لأول مرة
            initializeTinyMCE();

            // استمع لأي تغيير في الثيم (الوضع المظلم) وأعد تفعيل المحرر
            const toggleButton = document.getElementById('darkModeToggle');
            if (toggleButton) {
                // نستخدم MutationObserver لمراقبة التغييرات على الـ class في عنصر <html>
                const observer = new MutationObserver(function(mutations) {
                    mutations.forEach(function(mutation) {
                        if (mutation.attributeName === "class") {
                            // عندما يتغير الكلاس، أعد تفعيل المحرر
                            initializeTinyMCE();
                        }
                    });
                });
                observer.observe(document.documentElement, {
                    attributes: true
                });
            }
        });
    </script>
@endpush
