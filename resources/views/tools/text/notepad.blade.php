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
            <h1><i class="fas fa-sticky-note"></i> {{ $title }}</h1>
            <p>{{ $description }}</p>
        </div>

        <div class="card">
            <div class="flex justify-between items-center" style="margin-bottom: var(--spacing-md);">
                <div style="color: var(--text-secondary);">
                    <span id="saveStatus"><i class="fas fa-check"></i> Auto-saved</span>
                </div>
                <div class="flex gap-sm">
                    <button onclick="downloadText()" class="btn btn-outline btn-sm"><i class="fas fa-download"></i>
                        Download</button>
                    <button onclick="clearText()" class="btn btn-outline btn-sm"><i class="fas fa-trash"></i> Clear</button>
                </div>
            </div>

            <textarea id="notepad" class="form-input"
                placeholder="Start typing... Your text is automatically saved to your browser's local storage."
                oninput="handleInput()"></textarea>

            <div class="flex justify-between items-center"
                style="margin-top: var(--spacing-md); color: var(--text-secondary); font-size: 0.9rem;">
                <div>
                    Words: <span id="wordCount">0</span> | Characters: <span id="charCount">0</span>
                </div>
                <div>
                    <button onclick="copyText()" class="btn btn-text"><i class="fas fa-copy"></i> Copy to Clipboard</button>
                </div>
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