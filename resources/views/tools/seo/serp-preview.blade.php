@extends('layouts.app')

@section('title', $title)
@section('meta_description', $description)

@section('styles')
    <style>
        .tool-container {
            max-width: 900px;
            margin: var(--spacing-2xl) auto;
            padding: 0 var(--spacing-lg);
        }

        .serp-preview {
            background: #f8f9fa;
            padding: var(--spacing-xl);
            border-radius: var(--radius-md);
            margin-top: var(--spacing-lg);
        }

        .serp-result {
            font-family: Arial, sans-serif;
        }

        .serp-title {
            color: #1a0dab;
            font-size: 20px;
            font-weight: normal;
            margin-bottom: 4px;
            cursor: pointer;
            text-decoration: none;
        }

        .serp-title:hover {
            text-decoration: underline;
        }

        .serp-url {
            color: #006621;
            font-size: 14px;
            margin-bottom: 4px;
        }

        .serp-description {
            color: #545454;
            font-size: 14px;
            line-height: 1.57;
        }

        .char-count {
            font-size: 0.875rem;
            color: var(--text-muted);
            margin-top: var(--spacing-xs);
        }

        .char-count.warning {
            color: #ff9500;
        }

        .char-count.error {
            color: #ff0055;
        }
    </style>
@endsection

@section('content')
    <div class="tool-container">
        <div class="tool-header">
            <h1><i class="fas fa-search"></i> {{ $title }}</h1>
            <p>{{ $description }}</p>
        </div>

        <div class="card">
            <div class="form-group">
                <label class="form-label">Page Title</label>
                <input type="text" id="titleInput" class="form-input" placeholder="Your Awesome Page Title - Brand Name"
                    value="Example Page Title - ToolsHub">
                <div class="char-count"><span id="titleCount">0</span>/60 characters (optimal)</div>
            </div>

            <div class="form-group">
                <label class="form-label">Meta Description</label>
                <textarea id="descInput" class="form-input" rows="3"
                    placeholder="Write a compelling description that will appear in search results...">This is an example meta description that shows how your page will appear in Google search results. Make it engaging!</textarea>
                <div class="char-count"><span id="descCount">0</span>/160 characters (optimal)</div>
            </div>

            <div class="form-group">
                <label class="form-label">URL</label>
                <input type="text" id="urlInput" class="form-input" placeholder="https://example.com/page-slug"
                    value="https://toolshub.com/tools/seo/serp-preview">
            </div>

            <div class="serp-preview">
                <h3 style="margin-bottom: var(--spacing-md); color: #333;">Google Search Preview</h3>
                <div class="serp-result" id="serpPreview">
                    <div class="serp-title">Example Page Title - ToolsHub</div>
                    <div class="serp-url">toolshub.com › tools › seo › serp-preview</div>
                    <div class="serp-description">This is an example meta description that shows how your page will appear
                        in Google search results. Make it engaging!</div>
                </div>
            </div>
        </div>

        <div class="card" style="margin-top: var(--spacing-xl);">
            <h3>SEO Best Practices:</h3>
            <ul style="padding-left: var(--spacing-lg); margin-top: var(--spacing-md);">
                <li><strong>Title:</strong> Keep it under 60 characters, include your main keyword</li>
                <li><strong>Description:</strong> Keep it under 160 characters, make it compelling</li>
                <li><strong>URL:</strong> Use descriptive, keyword-rich URLs with hyphens</li>
                <li><strong>Uniqueness:</strong> Every page should have unique title and description</li>
            </ul>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        const titleInput = document.getElementById('titleInput');
        const descInput = document.getElementById('descInput');
        const urlInput = document.getElementById('urlInput');

        function updatePreview() {
            const title = titleInput.value || 'Your Page Title Will Appear Here';
            const desc = descInput.value || 'Your meta description will appear here. Make it compelling to increase click-through rates.';
            const url = urlInput.value || 'https://example.com/page';

            // Update character counts
            const titleLen = titleInput.value.length;
            const descLen = descInput.value.length;

            document.getElementById('titleCount').textContent = titleLen;
            document.getElementById('descCount').textContent = descLen;

            // Add warning colors
            const titleCountEl = document.getElementById('titleCount').parentElement;
            const descCountEl = document.getElementById('descCount').parentElement;

            titleCountEl.className = 'char-count';
            if (titleLen > 60) titleCountEl.classList.add('error');
            else if (titleLen > 50) titleCountEl.classList.add('warning');

            descCountEl.className = 'char-count';
            if (descLen > 160) descCountEl.classList.add('error');
            else if (descLen > 150) descCountEl.classList.add('warning');

            // Format URL for display
            let displayUrl = url.replace(/^https?:\/\//, '').replace(/\/$/, '');
            const urlParts = displayUrl.split('/');
            if (urlParts.length > 1) {
                displayUrl = urlParts[0] + ' › ' + urlParts.slice(1).join(' › ');
            }

            // Truncate if too long
            const truncatedTitle = title.length > 60 ? title.substring(0, 57) + '...' : title;
            const truncatedDesc = desc.length > 160 ? desc.substring(0, 157) + '...' : desc;

            // Update preview
            document.getElementById('serpPreview').innerHTML = `
                    <div class="serp-title">${truncatedTitle}</div>
                    <div class="serp-url">${displayUrl}</div>
                    <div class="serp-description">${truncatedDesc}</div>
                `;
        }

        // Add event listeners
        titleInput.addEventListener('input', updatePreview);
        descInput.addEventListener('input', updatePreview);
        urlInput.addEventListener('input', updatePreview);

        // Initial update
        updatePreview();
    </script>
@endsection