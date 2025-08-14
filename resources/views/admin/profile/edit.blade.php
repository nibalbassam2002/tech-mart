@extends('layouts.admin')
@section('title', __('admin.my_profile'))

@section('content')
    <div class="pagetitle">
        <h1>{{ __('admin.profile') }}</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">{{ __('admin.home') }}</a></li>
                <li class="breadcrumb-item active">{{ __('admin.profile') }}</li>
            </ol>
        </nav>
    </div>

    <section class="section profile">
        <div class="row">
            <div class="col-xl-4">
                {{-- Profile Card --}}
                <div class="card">
                    <div class="card-body profile-card pt-4 d-flex flex-column align-items-center">
                        <img src="{{ $user->avatar ? asset('storage/' . $user->avatar) : asset('images/default.jpg') }}"
                            alt="Profile" class="rounded-circle" style="width: 120px; height: 120px; object-fit: cover;">
                        <h2>{{ $user->name }}</h2>
                        <h3>{{ ucfirst($user->role) }}</h3>
                    </div>
                </div>
            </div>

            <div class="col-xl-8">
                <div class="card">
                    <div class="card-body pt-3">
                        <ul class="nav nav-tabs nav-tabs-bordered">
                            <li class="nav-item"><button class="nav-link active" data-bs-toggle="tab"
                                    data-bs-target="#profile-overview">{{ __('admin.overview') }}</button></li>
                            <li class="nav-item"><button class="nav-link" data-bs-toggle="tab"
                                    data-bs-target="#profile-edit">{{ __('admin.edit_profile') }}</button></li>
                            <li class="nav-item"><button class="nav-link" data-bs-toggle="tab"
                                    data-bs-target="#profile-change-password">{{ __('admin.change_password') }}</button>
                            </li>
                        </ul>
                        <div class="tab-content pt-2">
                            <div class="tab-pane fade show active profile-overview" id="profile-overview">
                                <h5 class="card-title">{{ __('admin.profile_details') }}</h5>
                                <div class="row">
                                    <div class="col-lg-3 col-md-4 label">{{ __('admin.full_name') }}</div>
                                    <div class="col-lg-9 col-md-8">{{ $user->name }}</div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-3 col-md-4 label">{{ __('admin.email') }}</div>
                                    <div class="col-lg-9 col-md-8">{{ $user->email }}</div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-3 col-md-4 label">{{ __('admin.role') }}</div>
                                    <div class="col-lg-9 col-md-8">{{ ucfirst($user->role) }}</div>
                                </div>
                            </div>

                            <div class="tab-pane fade profile-edit pt-3" id="profile-edit">
                                @if (session('status'))
                                    <div class="alert alert-success">{{ session('status') }}</div>
                                @endif
                                <form method="post" action="{{ route('admin.profile.update') }}"
                                    enctype="multipart/form-data">
                                    @csrf @method('patch')
                                    <div class="row mb-3">
                                        <label for="profileImage"
                                            class="col-md-4 col-lg-3 col-form-label">{{ __('admin.profile_image') }}</label>
                                        <div class="col-md-8 col-lg-9">
                                            <img src="{{ $user->avatar ? asset('storage/' . $user->avatar) : asset('images/default.jpg') }}"
                                                alt="Profile"
                                                style="width: 120px; height: 120px; object-fit: cover; margin-bottom: 10px;">
                                            <div class="pt-2 d-flex align-items-center">
                                                <input name="avatar" type="file" class="form-control me-2"
                                                    id="avatar">
                                                @if ($user->avatar)
                                                    <button type="button" class="btn btn-danger btn-sm flex-shrink-0"
                                                        title="{{ __('admin.remove_profile_image') }}"
                                                        id="removeAvatarBtn"><i class="bi bi-trash"></i></button>
                                                    <input type="hidden" name="remove_avatar" id="removeAvatarInput"
                                                        value="0">
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mb-3"><label for="name"
                                            class="col-md-4 col-lg-3 col-form-label">{{ __('admin.full_name') }}</label>
                                        <div class="col-md-8 col-lg-9"><input name="name" type="text"
                                                class="form-control" id="name" value="{{ old('name', $user->name) }}">
                                        </div>
                                    </div>
                                    <div class="row mb-3"><label for="email"
                                            class="col-md-4 col-lg-3 col-form-label">{{ __('admin.email') }}</label>
                                        <div class="col-md-8 col-lg-9"><input name="email" type="email"
                                                class="form-control" id="email"
                                                value="{{ old('email', $user->email) }}"></div>
                                    </div>
                                    <div class="text-center"><button type="submit"
                                            class="btn btn-primary">{{ __('admin.save_changes') }}</button></div>
                                </form>
                            </div>

                            <div class="tab-pane fade pt-3" id="profile-change-password">
                                @if (session('status') && !$errors->any())
                                    <div class="alert alert-success">{{ session('status') }}</div>
                                @endif
                                @if ($errors->updatePassword->any())
                                    <div class="alert alert-danger">
                                        <ul>
                                            @foreach ($errors->updatePassword->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif
                                <form method="post" action="{{ route('admin.password.update') }}">
                                    @csrf @method('put')
                                    <div class="row mb-3"><label for="current_password"
                                            class="col-md-4 col-lg-3 col-form-label">{{ __('admin.current_password') }}</label>
                                        <div class="col-md-8 col-lg-9"><input name="current_password" type="password"
                                                class="form-control" id="current_password" required></div>
                                    </div>
                                    <div class="row mb-3"><label for="password"
                                            class="col-md-4 col-lg-3 col-form-label">{{ __('admin.new_password') }}</label>
                                        <div class="col-md-8 col-lg-9"><input name="password" type="password"
                                                class="form-control" id="password" required></div>
                                    </div>
                                    <div class="row mb-3"><label for="password_confirmation"
                                            class="col-md-4 col-lg-3 col-form-label">{{ __('admin.reenter_new_password') }}</label>
                                        <div class="col-md-8 col-lg-9"><input name="password_confirmation"
                                                type="password" class="form-control" id="password_confirmation" required>
                                        </div>
                                    </div>
                                    <div class="text-center"><button type="submit"
                                            class="btn btn-primary">{{ __('admin.change_password') }}</button></div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                // Logic for the remove avatar button
                const removeBtn = document.getElementById('removeAvatarBtn');
                const removeInput = document.getElementById('removeAvatarInput');

                if (removeBtn) {
                    removeBtn.addEventListener('click', function() {
                        if (confirm('Are you sure you want to remove your profile image?')) {
                            removeInput.value = '1';
                            alert('Your profile image will be removed when you save changes.');
                            removeBtn.style.display = 'none';
                            // Optional: also hide the current avatar preview
                            document.querySelector('#profile-edit img').src =
                                "{{ asset('images/default.jpg') }}";
                        }
                    });
                }
            });
        </script>
    @endpush

@endsection
