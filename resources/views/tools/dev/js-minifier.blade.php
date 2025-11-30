@extends('layouts.app')

@section('title', $title)
@section('meta_description', $description)

@section('content')
    <div style="max-width: 1100px; margin: var(--spacing-2xl) auto; padding: 0 var(--spacing-lg);">
        <div class="tool-header">
            <h1><i class="fab fa-js"></i> {{$title }}</h1>
            <p>{{ $description }}</p>
        </div>

        <div class="card">
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: var(--spacing-lg);">
                <div>
                    <h3>Input JavaScript</h3>
                    <textarea id="input" class="form-input" style="min-height: 400px; font-family: monospace;"
                        placeholder="Paste your JavaScript code here...">
    function calculateSum(a, b) {
        // This calculates the sum
        const result = a + b;
        return result;
    }

    console.log(calculateSum(5, 10));</textarea>
                    <button onclick="minifyJS()" class="btn btn-primary"
                        style="width: 100%; margin-top: var(--spacing-md);">
                        <i class="fas fa-compress"></i> Minify JavaScript
                    </button>
                </div>
                <div>
                    <h3>Minified JavaScript</h3>
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
        function minifyJS() {
            const input = document.getElementById('input').value.trim();
            if (!input) return showToast('Please enter JavaScript code!', 'error');

            const minified = input
                .replace(/\/\/.*$/gm, '')            // Remove single-line comments
                .replace(/\/\*[\s\S]*?\*\//g, '')   // Remove multi-line comments
                .replace(/\n/g, '')                 // Remove newlines
                .replace(/\s+/g, ' ')               // Replace multiple spaces
                .replace(/\s*([{}();:,])\s*/g, '$1') // Remove spaces around operators
                .trim();

            document.getElementById('output').value = minified;
            const savings = ((1 - minified.length / input.length) * 100).toFixed(1);
            showToast(`JavaScript minified! Saved ${savings}%`);
        }

        function copyOutput() {
            const output = document.getElementById('output').value;
            if (!output) return showToast('Nothing to copy!', 'error');
            copyToClipboard(output);
        }

        minifyJS();
    </script>
@endsection