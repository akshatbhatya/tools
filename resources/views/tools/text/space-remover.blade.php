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
    </style>
@endsection

@section('content')
    <div class="tool-container">
        <div class="tool-header">
            <h1><i class="fas fa-broom"></i> {{ $title }}</h1>
            <p>{{ $description }}</p>
        </div>

        <div class="card">
            <div class="form-group">
                <label for="textInput" class="form-label">Enter Text with Extra Spaces:</label>
                <textarea id="textInput" class="form-textarea" placeholder="Paste text with extra spaces..."
                    rows="10"></textarea>
            </div>

            <div class="flex gap-md" style="margin: var(--spacing-lg) 0;">
                <button onclick="removeExtraSpaces()" class="btn btn-primary">Remove Extra Spaces</button>
                <button onclick="removeAllSpaces()" class="btn btn-secondary">Remove All Spaces</button>
                <button onclick="removeLineBreaks()" class="btn"
                    style="background: var(--gradient-accent); color: white;">Remove Line Breaks</button>
            </div>

            <div class="form-group">
                <label for="outputText" class="form-label">Cleaned Text:</label>
                <textarea id="outputText" class="form-textarea" readonly rows="10"></textarea>
            </div>

            <div class="flex gap-md">
                <button onclick="copyResult()" class="btn btn-primary"><i class="fas fa-copy"></i> Copy</button>
                <button onclick="clearAll()" class="btn btn-outline"><i class="fas fa-trash"></i> Clear</button>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        function removeExtraSpaces() {
            const input = document.getElementById('textInput').value;
            const result = input.replace(/\s+/g, ' ').trim();
            document.getElementById('outputText').value = result;
            showToast('Extra spaces removed!');
        }

        function removeAllSpaces() {
            const input = document.getElementById('textInput').value;
            const result = input.replace(/\s/g, '');
            document.getElementById('outputText').value = result;
            showToast('All spaces removed!');
        }

        function removeLineBreaks() {
            const input = document.getElementById('textInput').value;
            const result = input.replace(/\n/g, ' ').replace(/\s+/g, ' ').trim();
            document.getElementById('outputText').value = result;
            showToast('Line breaks removed!');
        }

        function copyResult() {
            const output = document.getElementById('outputText');
            if (!output.value) {
                showToast('Nothing to copy!', 'error');
                return;
            }
            output.select();
            document.execCommand('copy');
            showToast('Copied!');
        }

        function clearAll() {
            document.getElementById('textInput').value = '';
            document.getElementById('outputText').value = '';
        }
    </script>
@endsection