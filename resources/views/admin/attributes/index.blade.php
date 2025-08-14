@extends('layouts.admin')
@section('title', __('admin.manage_attributes'))

@section('content')
    <div class="pagetitle">
        <h1>{{ __('admin.manage_attributes') }}</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">{{ __('admin.home') }}</a></li>
                <li class="breadcrumb-item active">{{ __('admin.attributes') }}</li>
            </ol>
        </nav>
    </div>

    <div class="card">
        <div class="card-body">
            <h5 class="card-title">{{ __('admin.all_product_attributes') }}</h5>

            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <div class="d-flex justify-content-end mb-3">
                <a href="{{ route('admin.attributes.create') }}" class="btn btn-primary">
                    <i class="bi bi-plus"></i> {{ __('admin.add_new') }}
                </a>
            </div>

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
                        @forelse ($attributes as $attribute)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $attribute->name }}</td>
                                <td>
                                    <div class="d-flex gap-1">

                                        <a href="{{ route('admin.attributes.values.index', $attribute->id) }}"
                                            class="btn btn-sm btn-primary">
                                            {{ __('admin.values') }}
                                        </a>

                                        {{-- Edit Button with Tooltip --}}
                                        <a href="{{ route('admin.attributes.edit', $attribute->id) }}"
                                            class="btn btn-sm btn-warning" data-bs-toggle="tooltip" data-bs-placement="top"
                                            title="{{ __('admin.edit') }}">
                                            <i class="bi bi-pencil"></i>
                                        </a>

                                        {{-- Delete Button with Tooltip --}}
                                        <button type="button" class="btn btn-sm btn-danger delete-btn"
                                            data-id="{{ $attribute->id }}" data-bs-toggle="tooltip" data-bs-placement="top"
                                            title="{{ __('admin.delete') }}">
                                            <i class="bi bi-trash"></i>
                                        </button>

                                    </div>

                                    {{-- The delete form remains hidden and is triggered by the button above. No changes needed here. --}}
                                    <form id="delete-form-{{ $attribute->id }}"
                                        action="{{ route('admin.attributes.destroy', $attribute->id) }}" method="POST"
                                        class="d-none">
                                        @csrf
                                        @method('DELETE')
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="text-center">{{ __('admin.no_attributes_found') }}</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    {{-- SweetAlert script with dynamic dark mode support --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('.delete-btn').forEach(button => {
                button.addEventListener('click', function(event) {
                    event.preventDefault();
                    const attributeId = this.dataset.id;
                    const form = document.getElementById(`delete-form-${attributeId}`);

                    // === START: التعديل الذي أضفته ===

                    // 1. التحقق إذا كان الوضع المظلم مفعلاً
                    const isDarkMode = document.documentElement.classList.contains('dark-mode');

                    // 2. تجهيز إعدادات SweetAlert بناءً على الوضع
                    const swalConfig = {
                        title: 'Are you sure?',
                        text: "You won't be able to revert this!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonText: 'Yes, delete it!',
                        
                        // إعدادات ديناميكية للوضع المظلم والعادي
                        background: isDarkMode ? '#161b22' : '#fff',
                        color: isDarkMode ? '#c9d1d9' : '#545454',
                        confirmButtonColor: isDarkMode ? '#238636' : '#3085d6',
                        cancelButtonColor: isDarkMode ? '#da3633' : '#d33'
                    };
                    
                    // === END: نهاية التعديل ===

                    // 3. استدعاء SweetAlert مع الإعدادات الجديدة
                    Swal.fire(swalConfig).then((result) => {
                        if (result.isConfirmed) {
                            form.submit();
                        }
                    })
                });
            });
        });
    </script>

    {{-- Script for initializing tooltips (No changes needed here) --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
            var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl)
            })
        });
    </script>
@endpush
