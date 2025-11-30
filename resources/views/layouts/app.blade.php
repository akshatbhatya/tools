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

    <!-- Favicon -->
    <link rel="icon" type="image/svg+xml"
        href="data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 100 100'><text y='.9em' font-size='90'>🛠️</text></svg>">

    <!-- Styles -->
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    @yield('styles')
</head>

<body>
    <!-- Navigation -->
    <nav class="navbar" id="navbar">
        <div class="container">
            <a href="{{ url('/') }}" class="navbar-brand">🛠️ ToolsHub</a>

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
                    <h4>🛠️ ToolsHub</h4>
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