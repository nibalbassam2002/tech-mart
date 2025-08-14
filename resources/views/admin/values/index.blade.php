@extends('layouts.admin')
@section('title', __('admin.values_for') . ' ' . $attribute->name)

@section('content')
<div class="pagetitle">
    <h1>{{ __('admin.values_for') }} "{{ $attribute->name }}"</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.attributes.index') }}">{{ __('admin.attributes') }}</a></li>
            <li class="breadcrumb-item active">{{ __('admin.manage_values') }}</li>
        </ol>
    </nav>
</div><!-- End Page Title -->

<div class="card">
    <div class="card-body">
        <h5 class="card-title">{{ __('admin.add_new_value') }}</h5>
        
        <form action="{{ route('admin.attributes.values.store', $attribute->id) }}" method="POST" class="row g-3">
            @csrf
            <div class="col-md-10">
                <input type="text" name="value" class="form-control" placeholder="{{ __('admin.enter_new_value_placeholder') }}" required>
            </div>
            <div class="col-md-2">
                <button type="submit" class="btn btn-primary w-100">{{ __('admin.add') }}</button>
            </div>
        </form>
        <hr>
        <h5 class="card-title">{{ __('admin.existing_values') }}</h5>
        
        <table class="table">
            <tbody>
                @forelse($values as $value)
                    <tr>
                        <td>{{ $value->value }}</td>
                        <td class="text-end">
                            <form action="{{ route('admin.attributes.values.destroy', [$attribute->id, $value->id]) }}" method="POST" onsubmit="return confirm('{{ __('admin.are_you_sure') }}');">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger">{{ __('admin.delete') }}</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td class="text-center">{{ __('admin.no_values_added_yet') }}</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection