<aside id="sidebar" class="sidebar">
    <ul class="sidebar-nav" id="sidebar-nav">

        {{-- Dashboard Link --}}
        <li class="nav-item">
            {{-- ▼▼▼ هنا التعديلات ▼▼▼ --}}
            <a class="nav-link {{ request()->routeIs('admin.dashboard') ? '' : 'collapsed' }}"
                href="{{ route('admin.dashboard') }}">
                <i class="bi bi-grid"></i>
                <span>{{ __('admin.dashboard') }}</span>
            </a>
            
        </li>

        {{-- Title for the next section --}}
        <li class="nav-heading">{{ __('admin.store_management') }}</li>

        {{-- Categories Link --}}
        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('admin.categories.*') ? '' : 'collapsed' }}"
                href="{{ route('admin.categories.index') }}">
                <i class="bi bi-tag"></i>
                <span>{{ __('admin.categories') }}</span>
            </a>
        </li>

        {{-- Products Link --}}
        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('admin.products.*') ? '' : 'collapsed' }}"
                href="{{ route('admin.products.index') }}">
                <i class="bi bi-box-seam"></i>
                <span>{{ __('admin.products') }}</span>
            </a>
        </li>

        {{-- Attributes Link --}}
        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('admin.attributes.*') ? '' : 'collapsed' }}"
                href="{{ route('admin.attributes.index') }}">
                <i class="bi bi-list-check"></i>
                <span>{{ __('admin.attributes') }}</span>
            </a>
        </li>

    </ul>
</aside>
