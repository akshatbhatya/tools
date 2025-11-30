@extends('layouts.app')

@section('title', $title)
@section('meta_description', $description)

@section('content')
    <div style="max-width: 1100px; margin: var(--spacing-2xl) auto; padding: 0 var(--spacing-lg);">
        <div class="tool-header">
            <h1><i class="fab fa-css3-alt"></i> {{ $title }}</h1>
            <p>{{ $description }}</p>
        </div>

        <div class="card">
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: var(--spacing-lg);">
                <div>
                    <h3>Input CSS</h3>
                    <textarea id="input" class="form-input" style="min-height: 400px; font-family: monospace;"
                        placeholder="Paste your CSS code here...">
    body {
        margin: 0;
        padding: 0;
        font-family: Arial, sans-serif;
    }

    .container {
        max-width: 1200px;
        margin: 0 auto;
    }</textarea>
                    <button onclick="minifyCSS()" class="btn btn-primary"
                        style="width: 100%; margin-top: var(--spacing-md);">
                        <i class="fas fa-compress"></i> Minify CSS
                    </button>
                </div>
                <div>
                    <h3>Minified CSS</h3>
                    <textarea id="output" class="form-input" style="min-height: 400px; font-family: monospace;"
                        readonly></textarea>
                    <button onclick="copyOutput()" class="btn btn-primary"
                        style="width: 100%; margin-top: var(--spacing-md);">
                        <i class="fas fa-copy"></i> Copy
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script>
        function minifyCSS() {
            const input = document.getElementById('input').value.trim();
            if (!input) return showToast('Please enter CSS code!', 'error');

            const minified = input
                .replace(/\/\*[\s\S]*?\*\//g, '')  // Remove comments
                .replace(/\n/g, '')                 // Remove newlines
                .replace(/\s+/g, ' ')               // Replace multiple spaces
                .replace(/\s*{\s*/g, '{')           // Remove spaces around {
                .replace(/\s*}\s*/g, '}')           // Remove spaces around }
                .replace(/\s*:\s*/g, ':')           // Remove spaces around :
                .replace(/\s*;\s*/g, ';')           // Remove spaces around ;
                .replace(/;}/g, '}')                 // Remove last semicolon
                .trim();

            document.getElementById('output').value = minified;
            const savings = ((1 - minified.length / input.length) * 100).toFixed(1);
            showToast(`CSS minified! Saved ${savings}%`);
        }

        function copyOutput() {
            const output = document.getElementById('output').value;
            if (!output) return showToast('Nothing to copy!', 'error');
            copyToClipboard(output);
        }

        minifyCSS();
    </script>
@endsection