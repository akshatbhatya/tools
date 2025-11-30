@extends('layouts.app')

@section('title', $title)
@section('meta_description', $description)

@section('content')
    <div style="max-width: 900px; margin: var(--spacing-2xl) auto; padding: 0 var(--spacing-lg);">
        <div class="tool-header">
            <h1><i class="fas fa-tags"></i> {{ $title }}</h1>
            <p>{{ $description }}</p>
        </div>

        <div class="card">
            <div class="form-group">
                <label class="form-label">Site Title</label>
                <input type="text" id="siteTitle" class="form-input" placeholder="My Awesome Website"
                    value="ToolsHub - Free Online Tools">
            </div>

            <div class="form-group">
                <label class="form-label">Site Description</label>
                <textarea id="siteDescription" class="form-input" rows="3"
                    placeholder="A brief description of your website...">Free online tools for developers, designers, and content creators. JSON formatter, image compressor, SEO tools, and more.</textarea>
            </div>

            <div class="form-group">
                <label class="form-label">Keywords (comma separated)</label>
                <input type="text" id="siteKeywords" class="form-input" placeholder="tools, free, online, utility"
                    value="online tools, free tools, web tools, developer tools">
            </div>

            <div class="form-group">
                <label class="form-label">Author</label>
                <input type="text" id="siteAuthor" class="form-input" placeholder="John Doe">
            </div>

            <div class="form-group">
                <label class="form-label">Website URL</label>
                <input type="url" id="siteUrl" class="form-input" placeholder="https://example.com"
                    value="https://toolshub.com">
            </div>

            <!-- Open Graph -->
            <h3 style="margin-top: var(--spacing-xl); margin-bottom: var(--spacing-md);">Open Graph (Facebook/LinkedIn)</h3>

            <div class="form-group">
                <label class="form-label">OG Title (leave empty to use site title)</label>
                <input type="text" id="ogTitle" class="form-input" placeholder="Same as site title">
            </div>

            <div class="form-group">
                <label class="form-label">OG Description (leave empty to use site description)</label>
                <textarea id="ogDescription" class="form-input" rows="2" placeholder="Same as site description"></textarea>
            </div>

            <div class="form-group">
                <label class="form-label">OG Image URL</label>
                <input type="url" id="ogImage" class="form-input" placeholder="https://example.com/og-image.jpg">
            </div>

            <!-- Twitter Card -->
            <h3 style="margin-top: var(--spacing-xl); margin-bottom: var(--spacing-md);">Twitter Card</h3>

            <div class="form-group">
                <label class="form-label">Twitter Card Type</label>
                <select id="twitterCard" class="form-select">
                    <option value="summary">Summary</option>
                    <option value="summary_large_image" selected>Summary with Large Image</option>
                    <option value="app">App</option>
                    <option value="player">Player</option>
                </select>
            </div>

            <div class="form-group">
                <label class="form-label">Twitter Handle (optional)</label>
                <input type="text" id="twitterHandle" class="form-input" placeholder="@username">
            </div>

            <button onclick="generateMetaTags()" class="btn btn-primary"
                style="width: 100%; margin-top: var(--spacing-md);">
                <i class="fas fa-code"></i> Generate Meta Tags
            </button>

            <!-- Result -->
            <div id="output" style="display: none; margin-top: var(--spacing-xl);">
                <div
                    style="display: flex; justify-content: space-between; align-items: center; margin-bottom: var(--spacing-md);">
                    <h3>Generated Meta Tags</h3>
                    <button onclick="copyMetaTags()" class="btn btn-text">
                        <i class="fas fa-copy"></i> Copy
                    </button>
                </div>
                <pre
                    style="background: #1e1e1e; color: #d4d4d4; padding: var(--spacing-lg); border-radius: var(--radius-md); overflow-x: auto; font-family: 'Courier New', monospace; font-size: 0.875rem;"><code id="metaOutput"></code></pre>
            </div>
        </div>
    </div>

    <script>
        // Auto-generate on page load
        window.addEventListener('load', generateMetaTags);

        function generateMetaTags() {
            const title = document.getElementById('siteTitle').value.trim();
            const desc = document.getElementById('siteDescription').value.trim();
            const keywords = document.getElementById('siteKeywords').value.trim();
            const author = document.getElementById('siteAuthor').value.trim();
            const siteUrl = document.getElementById('siteUrl').value.trim() || 'https://yourwebsite.com';

            const ogTitle = document.getElementById('ogTitle').value.trim() || title;
            const ogDesc = document.getElementById('ogDescription').value.trim() || desc;
            const ogImage = document.getElementById('ogImage').value.trim() || 'https://yourwebsite.com/og-image.jpg';

            const twitterCard = document.getElementById('twitterCard').value;
            const twitterHandle = document.getElementById('twitterHandle').value.trim();

            if (!title || !desc) {
                showToast('Please fill in at least title and description!', 'error');
                return;
            }

            let metaTags = `<!-- Basic Meta Tags -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>${escapeHtml(title)}</title>
    <meta name="description" content="${escapeHtml(desc)}">`;

            if (keywords) {
                metaTags += `\n<meta name="keywords" content="${escapeHtml(keywords)}">`;
            }

            if (author) {
                metaTags += `\n<meta name="author" content="${escapeHtml(author)}">`;
            }

            metaTags += `\n\n<!-- Open Graph Meta Tags (Facebook, LinkedIn) -->
    <meta property="og:title" content="${escapeHtml(ogTitle)}">
    <meta property="og:description" content="${escapeHtml(ogDesc)}">
    <meta property="og:type" content="website">
    <meta property="og:url" content="${escapeHtml(siteUrl)}">
    <meta property="og:image" content="${escapeHtml(ogImage)}">`;

            metaTags += `\n\n<!-- Twitter Card Meta Tags -->
    <meta name="twitter:card" content="${twitterCard}">
    <meta name="twitter:title" content="${escapeHtml(ogTitle)}">
    <meta name="twitter:description" content="${escapeHtml(ogDesc)}">
    <meta name="twitter:image" content="${escapeHtml(ogImage)}">`;

            if (twitterHandle) {
                metaTags += `\n<meta name="twitter:site" content="${escapeHtml(twitterHandle)}">`;
            }

            document.getElementById('metaOutput').textContent = metaTags;
            document.getElementById('output').style.display = 'block';
            document.getElementById('output').scrollIntoView({ behavior: 'smooth', block: 'nearest' });
            showToast('Meta tags generated!');
        }

        function copyMetaTags() {
            const output = document.getElementById('metaOutput').textContent;
            copyToClipboard(output);
        }

        function escapeHtml(text) {
            const div = document.createElement('div');
            div.textContent = text;
            return div.innerHTML;
        }
    </script>
@endsection