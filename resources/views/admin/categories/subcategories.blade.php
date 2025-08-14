@extends('layouts.admin')
@section('title', __('admin.sub_categories_for', ['name' => $category->name]))

@section('content')
<div class="pagetitle">
    <h1>{{ __('admin.sub_categories_for', ['name' => $category->name]) }}</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.categories.index') }}">{{ __('admin.categories') }}</a></li>
            <li class="breadcrumb-item active">{{ __('admin.sub_categories') }}</li>
        </ol>
    </nav>
</div>

<div class="card">
    <div class="card-body">
        <h5 class="card-title">{{ __('admin.all_sub_categories_of', ['name' => $category->name]) }}</h5>
        
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <a href="{{ route('admin.categories.index') }}" class="btn btn-secondary mb-3"><i class="bi bi-arrow-left"></i> {{ __('admin.back_to_main_categories') }}</a>

        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>{{ __('admin.name') }}</th>
                        <th>{{ __('admin.actions') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($subcategories as $subcategory)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $subcategory->name }}</td>
                        <td>
                            <div class="dropdown">
                                <button class="btn btn-secondary btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    {{ __('admin.actions') }}
                                </button>
                                <ul class="dropdown-menu">
                                    <li>
                                        <a class="dropdown-item" href="{{ route('admin.categories.edit', $subcategory->id) }}">
                                            <i class="bi bi-pencil"></i> {{ __('admin.edit') }}
                                        </a>
                                    </li>
                                    <li><hr class="dropdown-divider"></li>
                                    <li>
                                        <form id="delete-form-{{ $subcategory->id }}" action="{{ route('admin.categories.destroy', $subcategory->id) }}" method="POST">
                                            @csrf @method('DELETE')
                                            <button type="button" class="dropdown-item text-danger delete-btn" data-id="{{ $subcategory->id }}">
                                                <i class="bi bi-trash"></i> {{ __('admin.delete') }}
                                            </button>
                                        </form>
                                    </li>
                                </ul>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="3" class="text-center">{{ __('admin.no_sub_categories_found', ['name' => $category->name]) }}</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@push('scripts')
{{-- SweetAlert for delete confirmation with dynamic dark mode support --}}
<script>
document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('.delete-btn').forEach(button => {
        button.addEventListener('click', function(event) {
            event.preventDefault();
            const categoryId = this.dataset.id;
            const form = document.getElementById(`delete-form-${categoryId}`);

            // === START: التعديل المطلوب هنا ===

            // 1. التحقق إذا كان الوضع المظلم مفعلاً
            const isDarkMode = document.documentElement.classList.contains('dark-mode');

            // 2. تجهيز إعدادات SweetAlert بناءً على الوضع
            const swalConfig = {
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, delete it!',

                // إعدادات ديناميكية للألوان بناءً على الوضع
                background: isDarkMode ? '#161b22' : '#fff',
                color: isDarkMode ? '#c9d1d9' : '#545454',
                confirmButtonColor: isDarkMode ? '#da3633' : '#d33',      // اللون الأحمر لتأكيد الحذف
                cancelButtonColor: isDarkMode ? '#6e7681' : '#3085d6'   // لون رمادي/أزرق للإلغاء
            };

            // === END: نهاية التعديل ===

            // 3. استدعاء SweetAlert مع الإعدادات الجديدة
            Swal.fire(swalConfig).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        });
    });
});
</script>
@endpush