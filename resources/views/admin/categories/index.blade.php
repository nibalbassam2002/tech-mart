@extends('layouts.admin')
@section('title', __('admin.manage_main_categories'))

@section('content')
<div class="pagetitle">
    <h1>{{ __('admin.main_categories') }}</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">{{ __('admin.home') }}</a></li>
            <li class="breadcrumb-item active">{{ __('admin.categories') }}</li>
        </ol>
    </nav>
</div>

<div class="card">
    <div class="card-body">
        <h5 class="card-title">{{ __('admin.all_main_categories') }}</h5>
        
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="d-flex justify-content-end mb-3">
            <a href="{{ route('admin.categories.create') }}" class="btn btn-primary">
                <i class="bi bi-plus"></i> {{ __('admin.add_new_category') }}
            </a>
        </div>

        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>{{ __('admin.name') }}</th>
                        <th>{{ __('admin.sub_categories') }}</th>
                        <th>{{ __('admin.actions') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($categories as $category)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td><strong>{{ $category->name }}</strong></td>
                        <td><span class="badge bg-info">{{ $category->children_count }}</span></td>
                        <td>
                            <div class="dropdown">
                                <button class="btn btn-secondary btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    {{ __('admin.actions') }}
                                </button>
                                <ul class="dropdown-menu">
                                    <li>
                                        <a class="dropdown-item" href="{{ route('admin.categories.subcategories', $category->id) }}">
                                            <i class="bi bi-eye"></i> {{ __('admin.view_subs') }}
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="{{ route('admin.categories.edit', $category->id) }}">
                                            <i class="bi bi-pencil"></i> {{ __('admin.edit') }}
                                        </a>
                                    </li>
                                    <li><hr class="dropdown-divider"></li>
                                    <li>
                                        {{-- We use SweetAlert for this, so the onsubmit is not needed --}}
                                        <form id="delete-form-{{ $category->id }}" action="{{ route('admin.categories.destroy', $category->id) }}" method="POST">
                                            @csrf @method('DELETE')
                                            <button type="button" class="dropdown-item text-danger delete-btn" data-id="{{ $category->id }}">
                                                <i class="bi bi-trash"></i> {{ __('admin.delete') }}
                                            </button>
                                        </form>
                                    </li>
                                </ul>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="4" class="text-center">{{ __('admin.no_main_categories_found') }}</td></tr>
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

            // 1. التحقق من الوضع المظلم
            const isDarkMode = document.documentElement.classList.contains('dark-mode');

            // 2. تجهيز إعدادات SweetAlert بناءً على الوضع
            const swalConfig = {
                title: 'Are you sure?',
                text: "Warning! Deleting a main category will also delete all its sub-categories. This action cannot be undone!",
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