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

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: var(--spacing-md);
            margin: var(--spacing-xl) 0;
        }

        .stat-card {
            background: var(--gradient-primary);
            color: white;
            padding: var(--spacing-lg);
            border-radius: var(--radius-lg);
            text-align: center;
        }

        .stat-value {
            font-size: 2rem;
            font-weight: 700;
            display: block;
        }

        .stat-label {
            font-size: 0.875rem;
            opacity: 0.9;
        }
    </style>
@endsection

@section('content')
    <div class="tool-container">
        <div class="tool-header">
            <h1><i class="fas fa-calculator"></i> {{ $title }}</h1>
            <p>{{ $description }}</p>
        </div>

        <x-ad-zone position="top" />

        <div class="card">
            <div class="form-group">
                <textarea id="textInput" class="form-input" rows="10" placeholder="Type or paste your text here..."
                    oninput="analyzeText()"></textarea>
            </div>

            <div class="flex gap-md" style="margin-bottom: var(--spacing-xl);">
                <button onclick="clearText()" class="btn btn-outline"><i class="fas fa-trash"></i> Clear Text</button>
                <button onclick="copyText()" class="btn btn-secondary"><i class="fas fa-copy"></i> Copy Text</button>
            </div>

            <div class="stats-grid">

                <div class="flex gap-md" style="margin-top: var(--spacing-lg);">
                    <button onclick="copyText()" class="btn btn-primary">📋 Copy Text</button>
                    <button onclick="clearText()" class="btn btn-outline">🗑️ Clear</button>
                </div>
            </div>

            <x-ad-zone position="bottom" />
        </div>
@endsection

    @section('scripts')
        <script>
            const textInput = document.getElementById('textInput');

            // Real-time counting
            textInput.addEventListener('input', updateCounts);

            function updateCounts() {
                const text = textInput.value;

                // Word count
                const words = text.trim().split(/\s+/).filter(word => word.length > 0);
                document.getElementById('wordCount').textContent = words.length;

                // Character count
                document.getElementById('charCount').textContent = text.length;

                // Character count (no spaces)
                document.getElementById('charCountNoSpaces').textContent = text.replace(/\s/g, '').length;

                // Sentence count
                const sentences = text.split(/[.!?]+/).filter(sentence => sentence.trim().length > 0);
                document.getElementById('sentenceCount').textContent = sentences.length;

                // Paragraph count
                const paragraphs = text.split(/\n+/).filter(para => para.trim().length > 0);
                document.getElementById('paragraphCount').textContent = paragraphs.length;

                // Reading time (average 200 words per minute)
                const readingTime = Math.ceil(words.length / 200);
                document.getElementById('readingTime').textContent = readingTime || 0;
            }

            function copyText() {
                textInput.select();
                document.execCommand('copy');
                showToast('Text copied to clipboard!');
            }

            function clearText() {
                textInput.value = '';
                updateCounts();
            }

            // Initialize counts
            updateCounts();
        </script>
    @endsection