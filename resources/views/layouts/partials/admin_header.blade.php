<header id="header" class="header fixed-top d-flex align-items-center">

    <div class="d-flex align-items-center justify-content-between">
        <a href="{{ route('admin.dashboard') }}" class="logo d-flex align-items-center">
            <img src="{{ asset('images/logo2.png') }}" alt="Logo" style="max-height: 40px;">
            <span class="d-none d-lg-block">{{ config('app.name', 'Tech-Mart') }}</span>
        </a>
        <i class="bi bi-list toggle-sidebar-btn"></i>
    </div>

    <nav class="header-nav ms-auto">
        <ul class="d-flex align-items-center gap-3">
            <li class="nav-item">
            <a class="nav-link nav-icon" href="#" id="darkModeToggle">
                <i class="bi bi-moon"></i> {{-- Moon icon for dark mode --}}
            </a>
        </li>

            {{-- Language Dropdown --}}
            <li class="nav-item dropdown">
                <a class="nav-link nav-icon" href="#" data-bs-toggle="dropdown">
                    <i class="bi bi-translate"></i>
                </a>
                <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                    <li>
                        <a class="dropdown-item d-flex align-items-center" href="{{ route('language.switch', 'en') }}">
                            <span>English</span>
                        </a>
                    </li>
                    <li>
                        <a class="dropdown-item d-flex align-items-center" href="{{ route('language.switch', 'ar') }}">
                            <span>العربية</span>
                        </a>
                    </li>
                </ul>
            </li>
            
            {{-- Profile Dropdown --}}
            <li class="nav-item dropdown pe-3">
                <a class="nav-link nav-profile d-flex align-items-center pe-0" href="#" data-bs-toggle="dropdown">
                    <img src="{{ auth()->user()->avatar ? asset('storage/' . auth()->user()->avatar) : asset('assets/img/profile-img.jpg') }}" alt="Profile" class="rounded-circle">
                    <span class="d-none d-md-block dropdown-toggle ps-2">{{ Auth::user()->name }}</span>
                </a>
                <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">
                    <li class="dropdown-header">
                        <h6>{{ Auth::user()->name }}</h6>
                    </li>
                    <li>
                        <hr class="dropdown-divider">
                    </li>
                    <li>
                        {{-- ▼▼▼ هنا التعديل الأول ▼▼▼ --}}
                        <a class="dropdown-item d-flex align-items-center" href="{{ route('admin.profile.edit') }}">
                            <i class="bi bi-person"></i>
                            <span>{{ __('admin.my_profile') }}</span>
                        </a>
                    </li>
                    <li>
                        <hr class="dropdown-divider">
                    </li>
                    <li>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            {{-- ▼▼▼ هنا التعديل الثاني ▼▼▼ --}}
                            <a class="dropdown-item d-flex align-items-center" href="{{ route('logout') }}" onclick="event.preventDefault(); this.closest('form').submit();">
                                <i class="bi bi-box-arrow-right"></i>
                                <span>{{ __('admin.sign_out') }}</span>
                            </a>
                        </form>
                    </li>
                </ul>
            </li><!-- End Profile Nav -->

        </ul>
    </nav><!-- End Icons Navigation -->

</header>