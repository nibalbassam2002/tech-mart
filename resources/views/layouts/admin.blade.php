<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="{{ app()->getLocale() == 'ar' ? 'rtl' : 'ltr' }}">

<head>
    <meta charset="utf-8">
    <script>
        // This script prevents a flash of light mode.
        (function() {
            const theme = localStorage.getItem('theme');
            if (theme === 'dark') {
                document.documentElement.classList.add('dark-mode');
            }
        })();
    </script>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>@yield('title', 'Dashboard') - {{ config('app.name') }}</title>
    <!-- Favicon, Fonts, Vendor CSS -->
    <link href="{{ asset('favicon.png') }}" rel="icon">
    <link href="https://fonts.gstatic.com" rel="preconnect">
    <link
        href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i"
        rel="stylesheet">
    @if (app()->getLocale() == 'ar')
        <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;700&display=swap" rel="stylesheet">
    @endif
    @if (app()->getLocale() == 'ar')
        <link href="{{ asset('assets/vendor/bootstrap/css/bootstrap.rtl.min.css') }}" rel="stylesheet">
    @else
        <link href="{{ asset('assets/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    @endif
    <link href="{{ asset('assets/vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" />
    <link href="{{ asset('assets/css/style.css') }}" rel="stylesheet">

    <style>
        /* === FINAL DARK MODE STYLES === */
        html.dark-mode body,
        html.dark-mode #main {
            background-color: #0d1117;
            color: #c9d1d9;
        }

        html.dark-mode .card,
        html.dark-mode .modal-content,
        html.dark-mode .list-group-item,
        html.dark-mode .header,
        html.dark-mode .sidebar,
        html.dark-mode .footer,
        html.dark-mode .pagetitle .breadcrumb,
        html.dark-mode #attributes-container.bg-light,
        html.dark-mode .table-hover>tbody>tr:hover>* {
            background-color: transparent !important;
            border-color: #30363d;
        }

        /* ======================================================= */
        /* ======   إصلاح مظهر التبويبات (Tabs) في الوضع المظلم   ====== */
        /* ======================================================= */

        /* 1. تنسيق الإطار السفلي للتبويبات */
        html.dark-mode .nav-tabs {
            border-bottom-color: #30363d;
        }

        /* 2. تنسيق الأزرار غير النشطة */
        html.dark-mode .nav-tabs .nav-link {
            color: #8b949e;
            /* لون رمادي ثانوي */
            background-color: transparent;
            border-color: transparent transparent #30363d;
        }

        /* 3. تنسيق الأزرار عند مرور الماوس فوقها */
        html.dark-mode .nav-tabs .nav-link:hover,
        html.dark-mode .nav-tabs .nav-link:focus {
            color: #c9d1d9;
            /* لون أوضح عند التفاعل */
            border-color: #21262d #21262d #30363d;
            isolation: isolate;
        }

        /* 4. تنسيق الزر النشط (هذا هو الإصلاح الرئيسي) */
        html.dark-mode .nav-tabs .nav-link.active {
            color: #f0f6fc;
            /* أوضح لون للنص */
            background-color: #161b22;
            /* نفس لون خلفية الكرت */
            border-color: #30363d #30363d transparent;
            /* لإعطاء شكل التبويب المتصل */
        }

        /* 5. إصلاح زر تسجيل الخروج الأزرق في الوضع المظلم */
        html.dark-mode .profile-edit-btn {
            /* افترضت وجود هذا الكلاس، يمكنك تغييره */
            background-color: #d29922;
            border-color: #bb8009;
            color: #ffffff;
        }

        html.dark-mode .profile-edit-btn:hover {
            background-color: #bb8009;
            border-color: #9e6a03;
        }

        html.dark-mode .form-check-label {
            color: #c9d1d9 !important;
            /* لون النص الأساسي الفاتح في الوضع المظلم */
        }

        html.dark-mode .sidebar-nav .nav-link,
        html.dark-mode .sidebar-nav .nav-heading,
        html.dark-mode .breadcrumb a {
            color: #8b949e;
        }

        html.dark-mode .sidebar-nav .nav-link.collapsed {
            background: transparent;
        }

        html.dark-mode .sidebar-nav .nav-link:hover {
            color: #f0f6fc;
            background: #21262d;
        }

        html.dark-mode .sidebar-nav .nav-link:not(.collapsed) {
            color: #f0f6fc;
            background: #0d6efd;
        }

        html.dark-mode .table,
        html.dark-mode .form-control,
        html.dark-mode .form-select,
        html.dark-mode .select2-container--bootstrap-5 .select2-selection,
        html.dark-mode .form-select[multiple] {
            color: #c9d1d9;
            background-color: #0d1117;
            border-color: #30363d;
        }

        html.dark-mode .form-select[multiple] option {
            background-color: #0d1117;
        }

        html.dark-mode .table td,
        html.dark-mode .table th,
        html.dark-mode .dropdown-divider {
            border-color: #30363d;
        }

        html.dark-mode .table thead th {
            background-color: #21262d;
        }








        html.dark-mode .text-muted {
            color: #8b949e !important;
        }

        html.dark-mode .form-label {
            color: #8b949e;
        }

        html.dark-mode .select2-dropdown {
            background-color: #161b22;
            border-color: #30363d;
        }

        html.dark-mode .select2-results__option {
            color: #c9d1d9;
        }

        html.dark-mode .select2-results__option--highlighted {
            background-color: #21262d;
        }

        /* === FINAL & POLISHED DARK MODE STYLES === */
        html.dark-mode body {
            background-color: #0d1117;
            color: #c9d1d9;
        }

        html.dark-mode #main {
            background-color: #0d1117;
        }

        html.dark-mode .card-title,
        html.dark-mode h1,
        html.dark-mode h2,
        html.dark-mode h3,
        html.dark-mode h4,
        html.dark-mode h5,
        html.dark-mode .pagetitle h1,
        html.dark-mode .logo span {
            color: #f0f6fc;
        }



        html.dark-mode .sidebar-nav .nav-link:hover {
            color: #f0f6fc;
            background: #21262d;
        }

        html.dark-mode .sidebar-nav .nav-link:not(.collapsed),
        html.dark-mode .sidebar-nav .nav-link.active {
            color: #f0f6fc;
            background: #0d6efd;
        }

        html.dark-mode .table {
            color: #c9d1d9;
        }

        html.dark-mode .table tbody tr {
            background-color: #161b22;
            /* Same as card background */
        }

        html.dark-mode .table-hover>tbody>tr:hover>* {
            background-color: #21262d;
        }

        html.dark-mode .table td,
        html.dark-mode .table th,
        html.dark-mode .dropdown-divider {
            border-color: #30363d;
        }

        html.dark-mode .table th,
        html.dark-mode .table td {
            background-color: #161b22 !important;
            /* Force dark background */
        }

        html.dark-mode .form-control,
        html.dark-mode .form-select,
        html.dark-mode .select2-container--bootstrap-5 .select2-selection {
            background-color: #0d1117;
            border-color: #30363d;
            color: #c9d1d9;
        }

        html.dark-mode .table {
            color: #c9d1d9;
        }

        html.dark-mode .form-control:focus,
        html.dark-mode .form-select:focus {
            border-color: #0d6efd;
        }

        html.dark-mode .table tbody td {
            color: #c9d1d9;
            /* Light gray color for table body text */
        }

        /* ======================================================= */
        /* ======   إصلاح شامل ونهائي لقائمة المستخدم المنسدلة   ====== */
        /* ======================================================= */

        /* استهداف القائمة المنسدلة في الهيدر تحديداً لضمان عدم التعارض */
        html.dark-mode .header-nav .dropdown-menu {
            background-color: #161b22;
            border-color: #30363d;
        }

        /* عنوان القائمة (مثل "Admin User") */
        html.dark-mode .header-nav .dropdown-header h6 {
            color: #8b949e;
            /* لون رمادي ثانوي ومقروء */
        }

        /* عناصر القائمة (مثل "My Profile", "Sign Out") */
        html.dark-mode .header-nav .dropdown-item {
            color: #c9d1d9;
            /* اللون الأساسي الفاتح والمقروء */
            display: flex;
            align-items: center;
            gap: 10px;
            /* مسافة بين الأيقونة والنص */
        }

        /* أيقونات العناصر داخل القائمة */
        html.dark-mode .header-nav .dropdown-item i {
            color: #8b949e;
            /* لون رمادي للأيقونات */
        }

        /* لون العنصر والأيقونة عند مرور الماوس */
        html.dark-mode .header-nav .dropdown-item:hover {
            background-color: #21262d;
            color: #f0f6fc;
            /* لون أكثر سطوعاً للنص */
        }

        html.dark-mode .header-nav .dropdown-item:hover i {
            color: #f0f6fc;
            /* نفس لون النص عند التفاعل */
        }

        /* لون الفاصل (الخط) داخل القائمة */
        html.dark-mode .header-nav .dropdown-divider {
            border-top-color: #30363d;
        }

        html.dark-mode .text-muted {
            color: #8b949e !important;
        }

        /* ======================================================= */
        /* ======   إصلاح شامل ونهائي لكل القوائم المنسدلة   ====== */
        /* ======================================================= */

        /* 1. القاعدة العامة لخلفية القوائم المنسدلة */
        html.dark-mode .dropdown-menu {
            background-color: #161b22;
            border-color: #30363d;
        }

        /* 2. عنوان القائمة (إذا وجد) */
        html.dark-mode .dropdown-header {
            color: #8b949e;
        }

        /* 3. عناصر القائمة (الروابط) */
        html.dark-mode .dropdown-item {
            color: #c9d1d9;
        }

        /* 4. لون العنصر عند مرور الماوس */
        html.dark-mode .dropdown-item:hover,
        html.dark-mode .dropdown-item:focus {
            background-color: #21262d;
            color: #f0f6fc;
        }

        /* 5. تخصيص لون عنصر الحذف الأحمر */
        html.dark-mode .dropdown-item.text-danger {
            color: #f85149;
            /* لون أحمر فاتح */
        }

        html.dark-mode .dropdown-item.text-danger:hover {
            background-color: #da3633;
            /* خلفية حمراء داكنة عند التفاعل */
            color: #ffffff;
        }

        /* 6. لون الفاصل (الخط) */
        html.dark-mode .dropdown-divider {
            border-top-color: #30363d;
        }

        html.dark-mode .text-primary {
            color: #58a6ff !important;
        }

        html.dark-mode .badge.bg-info {
            background-color: #316dca !important;
            color: #c9d1d9;
        }

        html.dark-mode .card-icon {
            color: #0d6efd;
            background: #161b22;
        }

        html.dark-mode .table thead th {
            background-color: #161b22;
            color: #f0f6fc;

        }

        html.dark-mode .datatable-top {
            background-color: #161b22;
        }

        /* ================================================================= */
        /* === تحسين شامل لوضوح النصوص في الوضع المظلم (نسخة نهائية) === */
        /* ================================================================= */

        /* 1. اجعل لون النص الافتراضي داخل الكروت واضحاً */
        html.dark-mode .card-body {
            color: #c9d1d9;
        }

        /* 2. ميّز العناوين (مثل Category:, Price:, Laptops Brand) بلون أفتح وخط أثقل */
        html.dark-mode .card-body strong,
        html.dark-mode dt {
            color: #f0f6fc;
            /* لون أبيض فاتح جداً للتميز */
            font-weight: 600;
        }

        /* 3. اجعل القيم (مثل 'hp', '128GB') بلون فاتح وخط عادي */
        html.dark-mode dd,
        html.dark-mode .list-group-item span {
            color: #c9d1d9;
            font-weight: 400;
        }

        /* 4. تأكد من أن وصف المنتج (الذي يأتي من محرر TinyMCE) واضح أيضاً */
        html.dark-mode .card-body .description-content p,
        html.dark-mode .card-body .description-content div {
            color: #c9d1d9 !important;
        }

        /* 5. تأكد من أن لون خلفية الكروت هو اللون الداكن الصحيح (مهم جداً) */
        html.dark-mode .card {
            background-color: #161b22 !important;
            /* هذا يحل مشكلة الخلفية الشفافة */
        }

        html.dark-mode .select2-container--bootstrap-5 .select2-selection {
            background-color: #0d1117;
            border-color: #30363d;
            color: #c9d1d9;
        }

        /* لون الـ placeholder (النص الباهت قبل الاختيار) */
        html.dark-mode .select2-container--bootstrap-5 .select2-selection .select2-selection__rendered {
            color: #8b949e;
            /* لون رمادي متوسط الوضوح */
        }

        /* لون النص بعد الاختيار */
        html.dark-mode .select2-container--bootstrap-5 .select2-selection .select2-selection__rendered:not(:empty) {
            color: #c9d1d9;
            /* لون النص الأساسي الفاتح */
        }

        /* لون القائمة المنسدلة عند فتحها */
        html.dark-mode .select2-dropdown {
            background-color: #161b22;
            border-color: #30363d;
        }

        /* لون الخيارات داخل القائمة */
        html.dark-mode .select2-results__option {
            color: #c9d1d9;
        }

        /* لون الخيار عند مرور الماوس فوقه */
        html.dark-mode .select2-results__option--highlighted {
            background-color: #21262d;
        }
    </style>
    @if (app()->getLocale() == 'ar')
        <style>
            /* RTL STYLES */
            body,
            .pagetitle h1,
            .pagetitle .breadcrumb,
            .card-title,
            .modal-title,
            .logo span,
            .nav-heading {
                font-family: 'Cairo', sans-serif !important;
            }

            .sidebar {
                left: auto;
                right: 0;
            }

            #main,
            #footer {
                margin-left: 0;
                margin-right: 300px;
            }

            .toggle-sidebar .sidebar {
                right: -300px;
            }

            .toggle-sidebar #main,
            .toggle-sidebar #footer {
                margin-right: 0;
            }

            @media (max-width: 1199px) {

                #main,
                #footer {
                    margin-right: 0;
                }

                .toggle-sidebar #main,
                .toggle-sidebar #footer {
                    margin-right: 300px;
                }
            }

            .header-nav .dropdown-menu {
                left: 0 !important;
                right: auto !important;
            }

            .toggle-sidebar-btn {
                margin-right: 0 !important;
                margin-left: 20px !important;
            }

            .sidebar-nav .nav-link i {
                margin-right: 0;
                margin-left: 10px;
            }

            .breadcrumb-item+.breadcrumb-item::before {
                float: right;
            }

            .text-end {
                text-align: left !important;
            }

            .text-start {
                text-align: right !important;
            }

            .ps-3 {
                padding-right: 1rem !important;
                padding-left: 0 !important;
            }

            .ms-auto {
                margin-right: auto !important;
                margin-left: 0 !important;
            }

            .table,
            .table th,
            .table td {
                text-align: right;
            }
        </style>
    @endif
    @stack('styles')
</head>

<body>
    @include('layouts.partials.admin_header')
    @include('layouts.partials.admin_sidebar')
    <main id="main" class="main">@yield('content')</main>
    <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i
            class="bi bi-arrow-up-short"></i></a>
    <!-- JS Files -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="{{ asset('assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/tinymce/tinymce.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="{{ asset('assets/js/main.js') }}"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const toggleButton = document.getElementById('darkModeToggle');
            const htmlElement = document.documentElement;
            const toggleIcon = toggleButton.querySelector('i');

            function applyTheme(theme) {
                if (theme === 'dark') {
                    htmlElement.classList.add('dark-mode');
                    toggleIcon.classList.remove('bi-moon');
                    toggleIcon.classList.add('bi-sun');
                } else {
                    htmlElement.classList.remove('dark-mode');
                    toggleIcon.classList.remove('bi-sun');
                    toggleIcon.classList.add('bi-moon');
                }
            }

            toggleButton.addEventListener('click', function(e) {
                e.preventDefault();
                const newTheme = htmlElement.classList.contains('dark-mode') ? 'light' : 'dark';
                localStorage.setItem('theme', newTheme);
                applyTheme(newTheme);
            });

            applyTheme(localStorage.getItem('theme') || 'light');
        });
    </script>
    @stack('scripts')
</body>

</html>
