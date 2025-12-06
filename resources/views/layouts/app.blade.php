<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description"
        content="@yield('meta_description', 'Free online tools for PDF, images, text, SEO, and more. Boost your productivity with our collection of web tools.')">
    <meta name="keywords"
        content="@yield('meta_keywords', 'online tools, PDF tools, image tools, text tools, SEO tools, calculators')">
    <title>@yield('title', 'Web Tools Hub - Free Online Tools')</title>

    <!-- Open Graph Meta Tags -->
    <meta property="og:title" content="@yield('title', 'Web Tools Hub')">
    <meta property="og:description" content="@yield('meta_description', 'Free online tools for everyone')">
    <meta property="og:type" content="website">

    @php
        use App\Models\Setting;
        use App\Models\Page;
        use Illuminate\Support\Facades\Route;

        $googleSiteVerification = Setting::get('google_site_verification');

        // Fetch SEO data for current page
        $currentRoute = Route::currentRouteName();
        $pageSeo = Page::where('route_name', $currentRoute)->first();

        $metaTitle = $pageSeo->meta_title ?? $pageSeo->title ?? 'Web Tools Hub - Free Online Tools';
        $metaDescription = $pageSeo->meta_description ?? 'Free online tools for PDF, images, text, SEO, and more. Boost your productivity with our collection of web tools.';
        $metaKeywords = $pageSeo->meta_keywords ?? 'online tools, PDF tools, image tools, text tools, SEO tools, calculators';
        $canonicalUrl = $pageSeo->canonical_url ?? url()->current();
        $ogImage = $pageSeo->og_image ?? asset('images/og-image.jpg'); // Fallback to default image
        $schemaMarkup = $pageSeo->schema_markup ?? null;
    @endphp

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="@yield('meta_description', $metaDescription)">
    <meta name="keywords" content="@yield('meta_keywords', $metaKeywords)">
    <link rel="canonical" href="@yield('canonical_url', $canonicalUrl)">
    <title>@yield('title', $metaTitle)</title>

    <!-- Schema Markup -->
    @if($schemaMarkup)
        {!! $schemaMarkup !!}
    @endif

    <!-- Open Graph Meta Tags -->
    <meta property="og:title" content="@yield('title', $metaTitle)">
    <meta property="og:description" content="@yield('meta_description', $metaDescription)">
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:image" content="{{ $ogImage }}">

    <!-- Google Site Verification -->
    @if($googleSiteVerification)
        <meta name="google-site-verification" content="{{ $googleSiteVerification }}">
    @endif

    <!-- Favicon -->
    <link rel="icon" type="image/svg+xml"
        href="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 512 512'%3E%3Cpath fill='%2300f2ff' d='M152.1 38.2c9.9 8.9 10.7 24 1.8 33.9l-72 80c-4.4 4.9-10.6 7.8-17.2 7.9s-12.9-2.4-17.6-7L7 113C2.5 108.5 0 102.4 0 96s2.5-12.5 7-17l40-40c4.5-4.5 10.6-7 17-7s12.5 2.5 17 7l37.1 37.1 33.9-33.9zM224 96c0-17.7 14.3-32 32-32h96c17.7 0 32 14.3 32 32v32h-160V96zM465 113l-40 40c-4.5 4.5-10.6 7-17 7s-12.5-2.5-17-7l-33.9-33.9L320 152.1c-8.9 9.9-24 10.7-33.9 1.8s-10.7-24-1.8-33.9l72-80c4.4-4.9 10.6-7.8 17.2-7.9s12.9 2.4 17.6 7L441 79c4.5 4.5 7 10.6 7 17s-2.5 12.5-7 17zM0 160v256c0 35.3 28.7 64 64 64h384c35.3 0 64-28.7 64-64V160H0zm256 128a32 32 0 1 1 0 64 32 32 0 1 1 0-64z'/%3E%3C/svg%3E">

    <!-- Styles -->
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    @php
        $googleAnalyticsId = Setting::get('google_analytics_id');
        $googleTagManagerId = Setting::get('google_tag_manager_id');
        $googleAdsEnabled = Setting::get('google_ads_enabled', false);
        $googleAdsClient = Setting::get('google_ads_client');
    @endphp

    <!-- Google Tag Manager -->
    @if($googleTagManagerId)
        <script>(function (w, d, s, l, i) {
                w[l] = w[l] || []; w[l].push({
                    'gtm.start':
                        new Date().getTime(), event: 'gtm.js'
                }); var f = d.getElementsByTagName(s)[0],
                    j = d.createElement(s), dl = l != 'dataLayer' ? '&l=' + l : ''; j.async = true; j.src =
                        'https://www.googletagmanager.com/gtm.js?id=' + i + dl; f.parentNode.insertBefore(j, f);
            })(window, document, 'script', 'dataLayer', '{{ $googleTagManagerId }}');</script>
    @endif

    <!-- Google Analytics -->
    @if($googleAnalyticsId)
        <script async src="https://www.googletagmanager.com/gtag/js?id={{ $googleAnalyticsId }}"></script>
        <script>
            window.dataLayer = window.dataLayer || [];
            function gtag() { dataLayer.push(arguments); }
            gtag('js', new Date());
            gtag('config', '{{ $googleAnalyticsId }}');
        </script>
    @endif

    <!-- Google AdSense -->
    @if($googleAdsEnabled && $googleAdsClient)
        <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client={{ $googleAdsClient }}"
            crossorigin="anonymous"></script>
    @endif

    @yield('styles')
</head>

<body>
    <!-- Google Tag Manager (noscript) -->
    @if($googleTagManagerId ?? false)
        <noscript><iframe src="https://www.googletagmanager.com/ns.html?id={{ $googleTagManagerId }}" height="0" width="0"
                style="display:none;visibility:hidden"></iframe></noscript>
    @endif
    <!-- Navigation -->
    <nav class="navbar" id="navbar">
        <div class="container">
            <a href="{{ url('/') }}" class="navbar-brand"><i class="fas fa-toolbox"></i> ToolsHub</a>

            <button class="menu-toggle" id="menuToggle" aria-label="Toggle menu">
                <svg width="24" height="24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M3 12h18M3 6h18M3 18h18" />
                </svg>
            </button>

            <ul class="navbar-menu" id="navbarMenu">
                <li><a href="{{ url('/') }}" class="navbar-link">Home</a></li>
                <li><a href="{{ url('/#pdf-tools') }}" class="navbar-link">PDF Tools</a></li>
                <li><a href="{{ url('/#text-tools') }}" class="navbar-link">Text Tools</a></li>
                <li><a href="{{ url('/#image-tools') }}" class="navbar-link">Image Tools</a></li>
                <li><a href="{{ url('/#seo-tools') }}" class="navbar-link">SEO Tools</a></li>
                <li><a href="{{ url('/#dev-tools') }}" class="navbar-link">Developer</a></li>
                <li><a href="{{ url('/#calculators') }}" class="navbar-link">Calculators</a></li>
            </ul>
        </div>
    </nav>

    <!-- Main Content -->
    <main>
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <div class="footer-content">
                <div class="footer-section">
                    <h4><i class="fas fa-toolbox"></i> ToolsHub</h4>
                    <p>Your one-stop destination for free online tools. Boost productivity with our collection of PDF,
                        text, image, SEO, and developer tools.</p>
                </div>

                <div class="footer-section">
                    <h4>Popular Tools</h4>
                    <ul class="footer-links">
                        <li><a href="{{ url('/tools/pdf/merge') }}">PDF Merge</a></li>
                        <li><a href="{{ url('/tools/text/word-counter') }}">Word Counter</a></li>
                        <li><a href="{{ url('/tools/image/compressor') }}">Image Compressor</a></li>
                        <li><a href="{{ url('/tools/seo/meta-generator') }}">Meta Tag Generator</a></li>
                    </ul>
                </div>

                <div class="footer-section">
                    <h4>Tool Categories</h4>
                    <ul class="footer-links">
                        <li><a href="{{ url('/#pdf-tools') }}">PDF Tools</a></li>
                        <li><a href="{{ url('/#text-tools') }}">Text Tools</a></li>
                        <li><a href="{{ url('/#image-tools') }}">Image Tools</a></li>
                        <li><a href="{{ url('/#seo-tools') }}">SEO Tools</a></li>
                        <li><a href="{{ url('/#dev-tools') }}">Developer Tools</a></li>
                        <li><a href="{{ url('/#calculators') }}">Calculators</a></li>
                    </ul>
                </div>

                <div class="footer-section">
                    <h4>Resources</h4>
                    <ul class="footer-links">
                        <li><a href="{{ url('/about') }}">About Us</a></li>
                        <li><a href="{{ url('/privacy') }}">Privacy Policy</a></li>
                        <li><a href="{{ url('/terms') }}">Terms of Service</a></li>
                        <li><a href="{{ url('/contact') }}">Contact</a></li>
                    </ul>
                </div>
            </div>

            <div class="footer-bottom">
                <p>&copy; {{ date('Y') }} ToolsHub. All rights reserved. Built with ❤️ for productivity.</p>
            </div>
        </div>
    </footer>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}"></script>
    @yield('scripts')
</body>

</html>