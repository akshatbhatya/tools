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

        .tool-header {
            text-align: center;
            margin-bottom: var(--spacing-2xl);
        }

        .conversion-buttons {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: var(--spacing-md);
            margin: var(--spacing-xl) 0;
        }
    </style>
@endsection

@section('content')
    <div class="tool-container">
        <div class="tool-header">
            <h1><i class="fas fa-font"></i> {{ $title }}</h1>
            <p>{{ $description }}</p>
        </div>

        <x-ad-zone position="top" />

        <div class="card">
            <div class="form-group">
                <textarea id="textInput" class="form-input" rows="8"
                    placeholder="Type or paste your text here..."></textarea>
            </div>

            <div class="grid grid-cols-3 gap-md" style="margin-bottom: var(--spacing-xl);">
                <button onclick="convertCase('upper')" class="btn btn-outline">UPPERCASE</button>
                <button onclick="convertCase('lower')" class="btn btn-outline">lowercase</button>
                <button onclick="convertCase('title')" class="btn btn-outline">Title Case</button>
                <button onclick="convertCase('sentence')" class="btn btn-outline">Sentence case</button>
                <button onclick="convertCase('toggle')" class="btn btn-outline">tOGGLE cASE</button>
                <button onclick="convertCase('camel')" class="btn btn-outline">camelCase</button>
            </div>

            <div class="form-group">
                <label for="outputText" class="form-label">Result:</label>
                <textarea id="outputText" class="form-textarea" placeholder="Converted text will appear here..." rows="10"
                    readonly></textarea>
            </div>

            <div class="flex gap-md">
                <button onclick="copyResult()" class="btn btn-primary">📋 Copy Result</button>
                <button onclick="clearAll()" class="btn btn-outline">🗑️ Clear All</button>
            </div>
        </div>

        <x-ad-zone position="bottom" />
    </div>
@endsection

@section('scripts')
    <script>
        function convertCase(type) {
            const input = document.getElementById('textInput').value;
            const output = document.getElementById('outputText');

            if (!input.trim()) {
                showToast('Please enter some text first!', 'error');
                return;
            }

            let result = '';

            switch (type) {
                case 'upper':
                    result = input.toUpperCase();
                    break;
                case 'lower':
                    result = input.toLowerCase();
                    break;
                case 'title':
                    result = input.toLowerCase().replace(/\b\w/g, char => char.toUpperCase());
                    break;
                case 'sentence':
                    result = input.toLowerCase().replace(/(^\s*\w|[.!?]\s*\w)/g, char => char.toUpperCase());
                    break;
                case 'toggle':
                    result = input.split('').map(char => {
                        return char === char.toUpperCase() ? char.toLowerCase() : char.toUpperCase();
                    }).join('');
                    break;
                case 'camel':
                    result = input.toLowerCase()
                        .replace(/[^a-zA-Z0-9]+(.)/g, (match, char) => char.toUpperCase())
                        .replace(/^[A-Z]/, char => char.toLowerCase());
                    break;
            }

            output.value = result;
            showToast('Text converted successfully!');
        }

        function copyResult() {
            const output = document.getElementById('outputText');
            if (!output.value) {
                showToast('Nothing to copy!', 'error');
                return;
            }
            output.select();
            document.execCommand('copy');
            showToast('Result copied to clipboard!');
        }

        function clearAll() {
            document.getElementById('textInput').value = '';
            document.getElementById('outputText').value = '';
        }
    </script>
@endsection