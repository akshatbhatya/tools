@extends('layouts.app')

@section('title', 'ToolsHub - Future of Online Tools')
@section('meta_description', 'Access next-gen online tools including PDF merge, image compressor, word counter, JSON formatter, and more. No signup required!')
@section('meta_keywords', 'online tools, PDF tools, image compressor, word counter, JSON formatter, calculators, SEO tools')

@section('content')
    <!-- Hero Section -->
    <section class="hero">
        <div class="container">
            <div class="hero-content">
                <h1><i class="fas fa-meteor"></i> Future Tools</h1>
                <p>Experience the next generation of web utilities. Powerful, fast, and beautifully designed for the modern
                    web.</p>
                <div class="flex justify-center gap-md">
                    <a href="#tools" class="btn btn-primary"><i class="fas fa-rocket"></i> Launch Tools</a>
                    <a href="#popular" class="btn btn-outline"><i class="fas fa-star"></i> Most Popular</a>
                </div>
            </div>
        </div>
    </section>

    <!-- Ad Zone - Top -->
    <x-ad-zone position="top" />

    <!-- PDF Tools Section (Bento Grid) -->
    <section class="section" id="pdf-tools">
        <div class="container">
            <div class="section-header">
                <h2><i class="fas fa-file-pdf"></i> PDF Studio</h2>
                <p class="section-subtitle">Advanced PDF manipulation suite</p>
            </div>

            <div class="grid grid-cols-3">
                <div style="grid-column: span 2;">
                    <x-tool-card icon="fas fa-paperclip" title="PDF Merge"
                        description="Combine multiple PDF files into one document with drag-and-drop simplicity."
                        url="/tools/pdf/merge" gradient="primary" />
                </div>

                <x-tool-card icon="fas fa-scissors" title="PDF Split"
                    description="Extract specific pages from your PDF files" url="/tools/pdf/split" gradient="secondary" />

                <x-tool-card icon="fas fa-compress" title="PDF Compress"
                    description="Reduce PDF file size without losing quality" url="/tools/pdf/compress" gradient="accent" />

                <x-tool-card icon="fas fa-file-word" title="PDF to Word"
                    description="Convert PDF documents to editable Word files" url="/tools/pdf/pdf-to-word"
                    gradient="warm" />

                <x-tool-card icon="fas fa-file-pdf" title="Word to PDF" description="Convert Word documents to PDF format"
                    url="/tools/pdf/word-to-pdf" gradient="cool" />

                <div style="grid-column: span 3;">
                    <x-tool-card icon="fas fa-images" title="Images to PDF"
                        description="Create PDF from multiple images. Supports JPG, PNG, and WebP formats."
                        url="/tools/pdf/images-to-pdf" gradient="primary" />
                </div>
            </div>
        </div>
    </section>

    <!-- Text Tools Section -->
    <section class="section" id="text-tools">
        <div class="container">
            <div class="section-header">
                <h2><i class="fas fa-pen-fancy"></i> Text Lab</h2>
                <p class="section-subtitle">Precision text manipulation tools</p>
            </div>

            <div class="grid grid-cols-4">
                <div style="grid-column: span 2;">
                    <x-tool-card icon="fas fa-calculator" title="Word Counter"
                        description="Real-time analysis of words, characters, sentences, and reading time."
                        url="/tools/text/word-counter" gradient="secondary" />
                </div>

                <div style="grid-column: span 2;">
                    <x-tool-card icon="fas fa-font" title="Case Converter"
                        description="Convert text to UPPER, lower, Title Case, and more." url="/tools/text/case-converter"
                        gradient="accent" />
                </div>

                <x-tool-card icon="fas fa-broom" title="Remove Spaces" description="Clean up extra spaces"
                    url="/tools/text/space-remover" gradient="warm" />

                <div style="grid-column: span 3;">
                    <x-tool-card icon="fas fa-sticky-note" title="Online Notepad"
                        description="Distraction-free writing environment with auto-save functionality."
                        url="/tools/text/notepad" gradient="cool" />
                </div>
            </div>
        </div>
    </section>

    <!-- Image Tools Section -->
    <section class="section" id="image-tools">
        <div class="container">
            <div class="section-header">
                <h2><i class="fas fa-image"></i> Image Forge</h2>
                <p class="section-subtitle">Next-gen image processing</p>
            </div>

            <div class="grid grid-cols-4">
                <div style="grid-column: span 4;">
                    <x-tool-card icon="fas fa-file-zipper" title="Image Compressor"
                        description="Intelligent compression algorithms to reduce file size while maintaining visual quality."
                        url="/tools/image/compressor" gradient="primary" />
                </div>

                <x-tool-card icon="fas fa-expand" title="Resizer" description="Resize images" url="/tools/image/resizer"
                    gradient="secondary" />

                <x-tool-card icon="fas fa-repeat" title="Converter" description="Convert formats"
                    url="/tools/image/converter" gradient="accent" />

                <x-tool-card icon="fas fa-crop" title="Cropper" description="Crop images" url="/tools/image/cropper"
                    gradient="warm" />

                <x-tool-card icon="fas fa-wand-magic-sparkles" title="Enhancer" description="Auto-enhance"
                    url="/tools/image/enhancer" gradient="cool" />
            </div>
        </div>
    </section>

    <!-- Ad Zone - Middle -->
    <x-ad-zone position="middle" />

    <!-- SEO Tools Section -->
    <section class="section" id="seo-tools">
        <div class="container">
            <div class="section-header">
                <h2><i class="fas fa-rocket"></i> SEO Command</h2>
                <p class="section-subtitle">Optimize for the search engines of tomorrow</p>
            </div>

            <div class="grid grid-cols-3">
                <x-tool-card icon="fas fa-tags" title="Meta Tag Generator" description="Generate SEO-friendly meta tags"
                    url="/tools/seo/meta-generator" gradient="cool" />

                <x-tool-card icon="fas fa-robot" title="Robots.txt Generator"
                    description="Create robots.txt for your website" url="/tools/seo/robots-generator" gradient="primary" />

                <x-tool-card icon="fas fa-search" title="SERP Preview" description="Preview Google search results"
                    url="/tools/seo/serp-preview" gradient="secondary" />

                <div style="grid-column: span 3;">
                    <x-tool-card icon="fas fa-check-circle" title="Index Checker"
                        description="Instantly check if your URL is indexed by Google." url="/tools/seo/index-checker"
                        gradient="accent" />
                </div>
            </div>
        </div>
    </section>

    <!-- Developer Tools Section -->
    <section class="section" id="dev-tools">
        <div class="container">
            <div class="section-header">
                <h2><i class="fas fa-code"></i> Dev Console</h2>
                <p class="section-subtitle">Essential utilities for developers</p>
            </div>

            <div class="grid grid-cols-3">
                <div style="grid-column: span 2;">
                    <x-tool-card icon="fas fa-code" title="JSON Formatter"
                        description="Format, validate, and minify JSON data with syntax highlighting."
                        url="/tools/dev/json-formatter" gradient="accent" />
                </div>

                <x-tool-card icon="fab fa-html5" title="HTML Formatter" description="Beautify HTML code"
                    url="/tools/dev/html-formatter" gradient="warm" />

                <x-tool-card icon="fab fa-css3-alt" title="CSS Minifier" description="Minify CSS code"
                    url="/tools/dev/css-minifier" gradient="cool" />

                <x-tool-card icon="fab fa-js" title="JS Minifier" description="Minify JavaScript code"
                    url="/tools/dev/js-minifier" gradient="primary" />

                <x-tool-card icon="fas fa-fingerprint" title="UUID Generator" description="Generate unique identifiers"
                    url="/tools/dev/uuid-generator" gradient="secondary" />

                <div style="grid-column: span 3;">
                    <x-tool-card icon="fas fa-paragraph" title="Lorem Ipsum Generator"
                        description="Generate placeholder text for your designs." url="/tools/dev/lorem-ipsum"
                        gradient="accent" />
                </div>
            </div>
        </div>
    </section>

    <!-- Calculators Section -->
    <section class="section" id="calculators">
        <div class="container">
            <div class="section-header">
                <h2><i class="fas fa-calculator"></i> Calc Hub</h2>
                <p class="section-subtitle">Quick and accurate calculations</p>
            </div>

            <div class="grid grid-cols-3">
                <div style="grid-column: span 3;">
                    <x-tool-card icon="fas fa-weight-scale" title="BMI Calculator"
                        description="Calculate your Body Mass Index with detailed health insights." url="/tools/calc/bmi"
                        gradient="warm" />
                </div>

                <x-tool-card icon="fas fa-birthday-cake" title="Age Calculator" description="Calculate age"
                    url="/tools/calc/age" gradient="cool" />

                <x-tool-card icon="fas fa-money-bill-wave" title="Loan Calculator" description="Calculate EMI"
                    url="/tools/calc/loan" gradient="primary" />

                <x-tool-card icon="fas fa-file-invoice-dollar" title="GST Calculator" description="Calculate GST"
                    url="/tools/calc/gst" gradient="secondary" />

                <x-tool-card icon="fas fa-percent" title="Percentage" description="Calculate %" url="/tools/calc/percentage"
                    gradient="accent" />

                <x-tool-card icon="fas fa-calendar-alt" title="Date Calc" description="Date diff" url="/tools/calc/date"
                    gradient="warm" />
            </div>
        </div>
    </section>

    <!-- Ad Zone - Bottom -->
    <x-ad-zone position="bottom" />

    <!-- CTA Section -->
    <section class="section" style="background: rgba(0, 242, 255, 0.05); border-top: 1px solid rgba(0, 242, 255, 0.1);">
        <div class="container text-center">
            <h2 style="color: var(--text-main); margin-bottom: var(--spacing-md);">Ready to Boost Your Productivity?</h2>
            <p style="color: var(--text-muted); font-size: 1.125rem; margin-bottom: var(--spacing-lg);">Access all tools
                instantly. No signup, no credit card required.</p>
            <a href="#tools" class="btn btn-primary">Start Using Tools</a>
        </div>
    </section>
@endsection