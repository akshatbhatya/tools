@extends('layouts.app')

@section('content')
    <div class="container" style="padding: var(--spacing-xl) 20px; margin-top: 80px;">
        <div class="content-card" style="width: 100%; max-width: 800px; margin: 0 auto;">
            <h1
                style="text-align: center; margin-bottom: var(--spacing-lg); background: var(--gradient-primary); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">
                About ToolsHub</h1>

            <div class="prose" style="color: var(--text-main); line-height: 1.6;">
                <p>Welcome to <strong>ToolsHub</strong>, your ultimate destination for free, high-quality online tools. We
                    believe that powerful utilities should be accessible to everyone, everywhere, without barriers.</p>

                <h3 style="color: var(--neon-primary); margin-top: var(--spacing-lg);">Our Mission</h3>
                <p>Our mission is simple: to simplify your digital life. Whether you're a student, developer, designer, or
                    business professional, our suite of tools is designed to help you get things done faster and more
                    efficiently.</p>

                <h3 style="color: var(--neon-primary); margin-top: var(--spacing-lg);">Why Choose Us?</h3>
                <ul style="list-style-type: none; padding: 0;">
                    <li style="margin-bottom: var(--spacing-sm);"><i class="fas fa-check-circle"
                            style="color: var(--neon-success); margin-right: 10px;"></i> <strong>100% Free:</strong> No
                        hidden fees, no subscriptions.</li>
                    <li style="margin-bottom: var(--spacing-sm);"><i class="fas fa-check-circle"
                            style="color: var(--neon-success); margin-right: 10px;"></i> <strong>Privacy First:</strong> We
                        process files securely and respect your data privacy.</li>
                    <li style="margin-bottom: var(--spacing-sm);"><i class="fas fa-check-circle"
                            style="color: var(--neon-success); margin-right: 10px;"></i> <strong>Fast & Reliable:</strong>
                        Optimized for speed and performance on any device.</li>
                    <li style="margin-bottom: var(--spacing-sm);"><i class="fas fa-check-circle"
                            style="color: var(--neon-success); margin-right: 10px;"></i> <strong>No Installation:</strong>
                        All tools run directly in your browser.</li>
                </ul>

                <h3 style="color: var(--neon-primary); margin-top: var(--spacing-lg);">Our Tools</h3>
                <p>We offer a wide range of utilities across various categories:</p>
                <ul>
                    <li><strong>PDF Tools:</strong> Merge, split, compress, and convert PDF documents.</li>
                    <li><strong>Image Tools:</strong> Compress, resize, crop, and convert images.</li>
                    <li><strong>Text Tools:</strong> Word counter, case converter, and more.</li>
                    <li><strong>Developer Tools:</strong> JSON formatter, code minifiers, and generators.</li>
                    <li><strong>SEO Tools:</strong> Meta tag generator, SERP preview, and analysis.</li>
                </ul>

                <p style="margin-top: var(--spacing-xl); text-align: center;">
                    <a href="{{ route('contact') }}" class="btn btn-primary">Contact Us</a>
                </p>
            </div>
        </div>
    </div>
@endsection