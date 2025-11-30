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

        .spinner {
            border: 4px solid rgba(255, 255, 255, 0.3);
            border-radius: 50%;
            border-top: 4px solid var(--neon-primary);
            width: 40px;
            height: 40px;
            animation: spin 1s linear infinite;
            margin: 0 auto var(--spacing-md);
        }

        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }

        .result-box {
            margin: var(--spacing-xl) 0;
            padding: var(--spacing-xl);
            border-radius: var(--radius-md);
        }

        .result-indexed {
            background: var(--gradient-accent);
            color: white;
        }

        .result-not-indexed {
            background: var(--gradient-warm);
            color: white;
        }

        .result-error {
            background: var(--gradient-secondary);
            color: white;
        }

        .meta-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: var(--spacing-md);
            margin-top: var(--spacing-lg);
        }

        .meta-card {
            background: rgba(255, 255, 255, 0.15);
            padding: var(--spacing-lg);
            border-radius: var(--radius-md);
        }

        .meta-card h4 {
            color: white;
            margin-bottom: var(--spacing-md);
        }

        .meta-item {
            margin-bottom: var(--spacing-sm);
            font-size: 0.9rem;
        }

        .meta-item strong {
            color: white;
        }
    </style>
@endsection

@section('content')
    <div class="tool-container">
        <div class="tool-header">
            <h1><i class="fas fa-check-circle"></i> {{ $title }}</h1>
            <p>{{ $description }}</p>
        </div>

        <div class="card">
            <div class="form-group">
                <label class="form-label">Enter URL to Check</label>
                <div style="display: flex; gap: var(--spacing-md);">
                    <input type="url" id="urlInput" class="form-input" placeholder="https://example.com"
                        value="https://example.com" style="flex: 1;">
                    <button onclick="checkIndexStatus()" class="btn btn-primary">
                        <i class="fas fa-search"></i> Check Status
                    </button>
                </div>
            </div>

            <div id="loadingMessage" style="display: none; text-align: center; margin: var(--spacing-xl) 0;">
                <div class="spinner"></div>
                <p>Analyzing URL and checking Google index...</p>
            </div>

            <div id="resultBox" style="display: none;"></div>
        </div>

        <div class="card" style="margin-top: var(--spacing-xl);">
            <h3>How It Works:</h3>
            <p style="margin-top: var(--spacing-md);">This tool checks if your webpage appears in Google's search index by
                performing a "site:" search query and analyzing the page metadata.</p>

            <h3 style="margin-top: var(--spacing-xl);">What Does It Mean?</h3>
            <ul style="margin-top: var(--spacing-md); padding-left: var(--spacing-xl);">
                <li><strong><i class="fas fa-check-circle"></i> Indexed:</strong> Your page is visible in Google search
                    results</li>
                <li><strong><i class="fas fa-times-circle"></i> Not Indexed:</strong> Your page is not yet indexed by Google
                </li>
            </ul>

            <h3 style="margin-top: var(--spacing-xl);">If Your Page Is Not Indexed:</h3>
            <ol style="margin-top: var(--spacing-md); padding-left: var(--spacing-xl);">
                <li>Submit your sitemap to Google Search Console</li>
                <li>Request indexing through Google Search Console</li>
                <li>Ensure your page is not blocked by robots.txt</li>
                <li>Make sure your page has quality content</li>
                <li>Build backlinks to your page</li>
            </ol>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        async function checkIndexStatus() {
            const urlInput = document.getElementById('urlInput').value.trim();
            const resultBox = document.getElementById('resultBox');
            const loadingMessage = document.getElementById('loadingMessage');

            if (!urlInput) {
                showToast('Please enter a URL!', 'error');
                return;
            }

            // Validate URL format
            try {
                new URL(urlInput);
            } catch (e) {
                showToast('Please enter a valid URL (e.g., https://example.com)', 'error');
                return;
            }

            // Show loading
            loadingMessage.style.display = 'block';
            resultBox.style.display = 'none';

            try {
                // Make AJAX request to check index
                const response = await fetch('/tools/seo/check-index', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({ url: urlInput })
                });

                const data = await response.json();

                loadingMessage.style.display = 'none';
                resultBox.style.display = 'block';

                if (!data.success) {
                    resultBox.className = 'result-box result-error';
                    resultBox.innerHTML = `
                            <div style="text-align: center;">
                                <div style="font-size: 4rem; margin-bottom: var(--spacing-md);">⚠️</div>
                                <h2 style="color: white;">Error</h2>
                                <p>${data.message}</p>
                            </div>
                        `;
                    return;
                }

                const meta = data.data;

                if (data.indexed) {
                    resultBox.className = 'result-box result-indexed';
                    resultBox.innerHTML = `
                            <div style="text-align: center;">
                                <div style="font-size: 4rem; margin-bottom: var(--spacing-md);">✅</div>
                                <h2 style="color: white; margin-bottom: var(--spacing-md);">Page is Indexed!</h2>
                                <p style="margin-bottom: var(--spacing-lg);">
                                    This page appears in Google's search index.
                                </p>
                            </div>

                            <div class="meta-grid">
                                <div class="meta-card">
                                    <h4>📄 Basic Information</h4>
                                    <div class="meta-item"><strong>Title:</strong> ${meta.title || 'Not found'}</div>
                                    <div class="meta-item"><strong>Description:</strong> ${meta.description || 'Not found'}</div>
                                    <div class="meta-item"><strong>Keywords:</strong> ${meta.keywords || 'Not specified'}</div>
                                    <div class="meta-item"><strong>Author:</strong> ${meta.author || 'Not specified'}</div>
                                    <div class="meta-item"><strong>Robots:</strong> ${meta.robots || 'Not specified'}</div>
                                    <div class="meta-item"><strong>Canonical:</strong> ${meta.canonical || 'Not specified'}</div>
                                </div>

                                ${meta.ogTitle ? `
                                <div class="meta-card">
                                    <h4>📱 Open Graph</h4>
                                    <div class="meta-item"><strong>OG Title:</strong> ${meta.ogTitle}</div>
                                    ${meta.ogDescription ? `<div class="meta-item"><strong>OG Description:</strong> ${meta.ogDescription}</div>` : ''}
                                    ${meta.ogImage ? `<div class="meta-item"><strong>OG Image:</strong> <a href="${meta.ogImage}" target="_blank" style="color: white; text-decoration: underline;">View</a></div>` : ''}
                                </div>
                                ` : ''}

                                ${meta.twitterCard ? `
                                <div class="meta-card">
                                    <h4>🐦 Twitter Card</h4>
                                    <div class="meta-item"><strong>Card Type:</strong> ${meta.twitterCard}</div>
                                    ${meta.twitterTitle ? `<div class="meta-item"><strong>Title:</strong> ${meta.twitterTitle}</div>` : ''}
                                </div>
                                ` : ''}
                            </div>

                            <div style="text-align: center; margin-top: var(--spacing-xl);">
                                <a href="https://www.google.com/search?q=site:${encodeURIComponent(urlInput)}" 
                                    target="_blank" class="btn btn-secondary" 
                                    style="background: white; color: var(--neon-primary);">
                                    <i class="fab fa-google"></i> View in Google Search
                                </a>
                            </div>
                        `;
                } else {
                    resultBox.className = 'result-box result-not-indexed';
                    resultBox.innerHTML = `
                            <div style="text-align: center;">
                                <div style="font-size: 4rem; margin-bottom: var(--spacing-md);">❌</div>
                                <h2 style="color: white; margin-bottom: var(--spacing-md);">Page Not Indexed</h2>
                                <p style="margin-bottom: var(--spacing-lg);">
                                    This page does not appear to be indexed by Google yet.
                                </p>
                            </div>

                            <div class="meta-card">
                                <h4>📊 Page Metadata</h4>
                                <div class="meta-item"><strong>Title:</strong> ${meta.title || 'Not found'}</div>
                                <div class="meta-item"><strong>Description:</strong> ${meta.description || 'Not found'}</div>
                                <div class="meta-item"><strong>Robots:</strong> ${meta.robots || 'Not specified'}</div>
                            </div>

                            <div style="margin-top: var(--spacing-lg); padding: var(--spacing-lg); background: rgba(255,255,255,0.15); border-radius: var(--radius-md);">
                                <h4 style="color: white; margin-bottom: var(--spacing-md);">💡 Tips to Get Indexed:</h4>
                                <ul style="text-align: left;">
                                    <li>Submit your sitemap to Google Search Console</li>
                                    <li>Request indexing through Google Search Console</li>
                                    <li>Ensure robots meta is not blocking indexing (current: ${meta.robots || 'Not specified'})</li>
                                    <li>Build quality backlinks to your page</li>
                                    <li>Create unique, valuable content</li>
                                </ul>
                            </div>
                        `;
                }

                resultBox.scrollIntoView({ behavior: 'smooth', block: 'nearest' });

            } catch (error) {
                loadingMessage.style.display = 'none';
                resultBox.style.display = 'block';
                resultBox.className = 'result-box result-error';
                resultBox.innerHTML = `
                        <div style="text-align: center;">
                            <div style="font-size: 4rem; margin-bottom: var(--spacing-md);">⚠️</div>
                            <h2 style="color: white;">Error</h2>
                            <p>Unable to check index status. Please try again.</p>
                            <p style="font-size: 0.9rem; margin-top: var(--spacing-md);">${error.message}</p>
                        </div>
                    `;
            }
        }

        // Allow Enter key to check
        document.getElementById('urlInput').addEventListener('keypress', function (e) {
            if (e.key === 'Enter') {
                checkIndexStatus();
            }
        });
    </script>
@endsection