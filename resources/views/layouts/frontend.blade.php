<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name', 'Tech-Mart') }}</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="{{ asset('frontend/css/style.css') }}">
</head>

<body>

    <header class="main-header">
        <div class="container d-flex justify-content-between align-items-center">
            <a href="{{ route('home') }}" class="site-brand text-decoration-none d-flex align-items-center">
                <img src="{{ asset('images/logo1.jpg') }}" alt="Logo" class="site-logo">
                <span class="fs-4 site-name">{{ config('app.name', 'Tech-Mart') }}</span>
            </a>

            <div class="header-actions d-flex align-items-center">
                <a href="#" class="btn btn-icon me-2" title="Wishlist"><i class="bi bi-heart"></i></a>
                <a href="#" class="btn btn-icon me-3" title="Shopping Cart"><i class="bi bi-cart3"></i></a>
                <a href="{{ route('login') }}" class="btn btn-outline-primary me-2">Login</a>
                <a href="{{ route('register') }}" class="btn btn-primary">Sign-up</a>
            </div>
        </div>
    </header>

    <main>
        @yield('content')
    </main>

    {{-- ▼▼▼ هذا هو الفوتر الجديد بهوية المتجر الإلكتروني ▼▼▼ --}}
    <footer class="main-footer">
        <div class="container">
            <div class="row py-5">
                {{-- Column 1: Brand and Socials --}}
                <div class="col-lg-4 col-md-6 mb-4 mb-lg-0">
                    <div class="d-flex align-items-center mb-3">
                        <img src="{{ asset('images/logo21-removebg-preview.png') }}" alt="Logo" height="40">
                        <span class="fs-4 ms-2 site-name">{{ config('app.name', 'Tech-Mart') }}</span>
                    </div>
                    <p class="text-muted">Your reliable source for high-quality products. Shop with confidence.</p>
                    <ul class="list-unstyled d-flex">
                        {{-- ▼▼▼ أضيفي هذا السطر الجديد ▼▼▼ --}}
                        <li class="ms-3"><a class="link-dark" href="https://wa.me/966XXXXXXXXX" target="_blank"><i
                                    class="bi bi-whatsapp fs-5"></i></a></li>
                        <li class="ms-3"><a class="link-dark" href="#"><i class="bi bi-twitter fs-5"></i></a>
                        </li>
                        <li class="ms-3"><a class="link-dark" href="#"><i class="bi bi-instagram fs-5"></i></a>
                        </li>
                        <li class="ms-3"><a class="link-dark" href="#"><i class="bi bi-facebook fs-5"></i></a>
                        </li>
                    </ul>
                </div>

                {{-- Column 2: Quick Links --}}
                <div class="col-lg-2 col-6 mb-4 mb-lg-0">
                    <h5 class="fw-bold">Company</h5>
                    <ul class="nav flex-column">
                        <li class="nav-item mb-2"><a href="#" class="nav-link p-0 text-muted">Home</a></li>
                        <li class="nav-item mb-2"><a href="#" class="nav-link p-0 text-muted">About</a></li>
                    </ul>
                </div>

                {{-- Column 3: Support Links --}}
                <div class="col-lg-2 col-6 mb-4 mb-lg-0">
                    <h5 class="fw-bold">Support</h5>
                    <ul class="nav flex-column">
                        <li class="nav-item mb-2"><a href="#" class="nav-link p-0 text-muted">Contact Us</a></li>
                        <li class="nav-item mb-2"><a href="#" class="nav-link p-0 text-muted">FAQs</a></li>
                    </ul>
                </div>

                {{-- Column 4: Newsletter --}}
                <div class="col-lg-4 col-md-6 mb-4 mb-lg-0">
                    <h5 class="fw-bold">Subscribe</h5>
                    <p class="text-muted">Get the latest deals and updates.</p>
                    <form>
                        <div class="input-group">
                            <input type="text" class="form-control" placeholder="Email address">
                            <button class="btn btn-primary" type="button">Go</button>
                        </div>
                    </form>
                </div>
            </div>

            <div class="d-flex flex-column flex-sm-row justify-content-between pt-4 mt-4 border-top">
                <p>&copy; {{ date('Y') }} {{ config('app.name') }}. All rights reserved.</p>
                {{-- ▼▼▼ أيقونات الدفع ▼▼▼ --}}
                <div class="payment-icons">
                    <img src="https://img.icons8.com/color/48/000000/visa.png" alt="Visa" width="38" />
                    <img src="https://img.icons8.com/color/48/000000/mastercard.png" alt="Mastercard" width="38" />
                    <img src="https://img.icons8.com/color/48/000000/paypal.png" alt="PayPal" width="38" />
                </div>
            </div>
        </div>
    </footer>
    {{-- ▲▲▲ نهاية الفوتر ▲▲▲ --}}

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
