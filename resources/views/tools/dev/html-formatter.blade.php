@extends('layouts.app')

@section('title', $title)
@section('meta_description', $description)

@section('styles')
    <style>
        .tool-container {
            max-width: 1100px;
            margin: var(--spacing-2xl) auto;
            padding: 0 var(--spacing-lg);
        }

        .tool-header {
            text-align: center;
            margin-bottom: var(--spacing-2xl);
        }

        .code-editor {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: var(--spacing-lg);
            margin-top: var(--spacing-lg);
        }

        @media (max-width: 968px) {
            .code-editor {
                grid-template-columns: 1fr;
            }
        }

        .code-panel {
            display: flex;
            flex-direction: column;
        }

        .code-panel h3 {
            margin-bottom: var(--spacing-md);
        }

        textarea {
            font-family: 'Courier New', monospace;
            font-size: 0.875rem;
            min-height: 400px;
            resize: vertical;
        }

        .action-buttons {
            display: flex;
            gap: var(--spacing-sm);
            margin-bottom: var(--spacing-md);
            flex-wrap: wrap;
        }
    </style>
@endsection

@section('content')
    <div class="tool-container">
        <div class="tool-header">
            <h1><i class="fab fa-html5"></i> {{ $title }}</h1>
            <p>{{ $description }}</p>
        </div>

        <div class="card">
            <div class="code-editor">
                <div class="code-panel">
                    <h3>Input HTML</h3>
                    <div class="action-buttons">
                        <button onclick="formatHTML()" class="btn btn-primary">
                            <i class="fas fa-magic"></i> Format
                        </button>
                        <button onclick="minifyHTML()" class="btn btn-outline">
                            <i class="fas fa-compress"></i> Minify
                        </button>
                        <button onclick="clearInput()" class="btn btn-text">
                            <i class="fas fa-trash"></i> Clear
                        </button>
                    </div>
                    <textarea id="input" class="form-input" placeholder="Paste your HTML code here..."><!DOCTYPE html><html><head><title>Example</title></head><body><div class="container"><h1>Hello World</h1><p>This is a paragraph.</p></div></body></html></textarea>
                </div>

                <div class="code-panel">
                    <h3>Formatted HTML</h3>
                    <div class="action-buttons">
                        <button onclick="copyOutput()" class="btn btn-primary">
                            <i class="fas fa-copy"></i> Copy
                        </button>
                        <button onclick="downloadHTML()" class="btn btn-outline">
                            <i class="fas fa-download"></i> Download
                        </button>
                    </div>
                    <textarea id="output" class="form-input" readonly placeholder="Formatted HTML will appear here..."></textarea>
                </div>
            </div>
        </div>

        <div class="card" style="margin-top: var(--spacing-xl);">
            <h3>About HTML Formatter:</h3>
            <p>This tool helps you format and beautify HTML code for better readability. It adds proper indentation and line breaks to make your code structure clear.</p>
            <ul style="padding-left: var(--spacing-lg); margin-top: var(--spacing-md);">
                <li><strong>Format:</strong> Beautifies HTML with proper indentation</li>
                <li><strong>Minify:</strong> Removes whitespace and line breaks to reduce file size</li>
                <li><strong>Download:</strong> Save the formatted HTML as a file</li>
            </ul>
        </div>
    </div>
@endsection

@section('scripts')
    @verbatim
    <script>
        function formatHTML() {
            const input = document.getElementById('input').value.trim();
            
            if (!input) {
                showToast('Please enter HTML code!', 'error');
                return;
            }

            try {
                const formatted = beautifyHTML(input);
                document.getElementById('output').value = formatted;
                showToast('HTML formatted successfully!');
            } catch (error) {
                showToast('Error formatting HTML: ' + error.message, 'error');
            }
        }

        function minifyHTML() {
            const input = document.getElementById('input').value.trim();
            
            if (!input) {
                showToast('Please enter HTML code!', 'error');
                return;
            }

            // Simple minification: remove extra whitespace and line breaks
            const minified = input
                .replace(/\n\s*\n/g, '\n')
                .replace(/\n/g, '')
                .replace(/\s+/g, ' ')
                .replace(/>\s+</g, '><')
                .trim();

            document.getElementById('output').value = minified;
            showToast('HTML minified successfully!');
        }

        function beautifyHTML(html) {
            let formatted = '';
            let indent = 0;
            const tab = '  '; // 2 spaces
            const selfClosingTags = ['input', 'br', 'img', 'hr', 'meta', 'link'];

            html.split(/>\s*</).forEach((node) => {
                if (node.match(/^\/\w/)) {
                    // Closing tag
                    indent = Math.max(0, indent - 1);
                }

                formatted += tab.repeat(indent);
                
                if (!node.startsWith('<')) {
                    formatted += '<';
                }
                formatted += node;
                if (!node.endsWith('>')) {
                    formatted += '>';
                }
                formatted += '\n';

                // Check if it's an opening tag (not self-closing)
                const isSelfClosing = selfClosingTags.some(tag => node.startsWith(tag));
                const isOpeningTag = node.match(/^<?\w/) && !node.match(/\/$/) && !isSelfClosing;
                
                if (isOpeningTag) {
                    indent++;
                }
            });

            return formatted.trim();
        }

        function clearInput() {
            document.getElementById('input').value = '';
            document.getElementById('output').value = '';
        }

        function copyOutput() {
            const output = document.getElementById('output').value;
            if (!output) {
                showToast('Nothing to copy!', 'error');
                return;
            }
            copyToClipboard(output);
        }

        function downloadHTML() {
            const output = document.getElementById('output').value;
            if (!output) {
                showToast('Nothing to download!', 'error');
                return;
            }

            const blob = new Blob([output], { type: 'text/html' });
            const url = URL.createObjectURL(blob);
            const a = document.createElement('a');
            a.href = url;
            a.download = 'formatted.html';
            document.body.appendChild(a);
            a.click();
            document.body.removeChild(a);
            URL.revokeObjectURL(url);
            showToast('HTML downloaded!');
        }

        // Format on page load
        formatHTML();
    </script>
    @endverbatim
@endsection
