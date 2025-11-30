@extends('layouts.app')

@section('title', $title)
@section('meta_description', $description)

@section('content')
    <div style="max-width: 800px; margin: var(--spacing-2xl) auto; padding: 0 var(--spacing-lg);">
        <div class="tool-header">
            <h1><i class="fas fa-paragraph"></i> {{ $title }}</h1>
            <p>{{ $description }}</p>
        </div>

        <div class="card">
            <div class="form-group">
                <label class="form-label">Number of Paragraphs</label>
                <input type="number" id="paragraphs" class="form-input" value="3" min="1" max="20">
            </div>

            <div class="form-group">
                <label class="form-label">Words per Paragraph</label>
                <input type="number" id="words" class="form-input" value="50" min="10" max="200">
            </div>

            <div class="form-group">
                <label class="checkbox-label">
                    <input type="checkbox" id="startWithLorem" checked> Start with "Lorem ipsum..."
                </label>
            </div>

            <button onclick="generateLorem()" class="btn btn-primary" style="width: 100%;">
                <i class="fas fa-magic"></i> Generate Text
            </button>

            <div id="output" style="margin-top: var(--spacing-xl); display: none;">
                <div style="display: flex; justify-content: space-between; margin-bottom: var(--spacing-md);">
                    <h3>Generated Text</h3>
                    <button onclick="copyOutput()" class="btn btn-text">
                        <i class="fas fa-copy"></i> Copy
                    </button>
                </div>
                <div id="loremText"
                    style="background: var(--bg-glass); padding: var(--spacing-lg); border-radius: var(--radius-md); line-height: 1.8;">
                </div>
            </div>
        </div>
    </div>

    <script>
        const loremWords = ['lorem', 'ipsom', 'dolor', 'sit', 'amet', 'consectetur', 'adipiscing', 'elit', 'sed', 'do', 'eiusmod', 'tempor', 'incididunt', 'ut', 'labore', 'et', 'dolore', 'magna', 'aliqua', 'enim', 'ad', 'minim', 'veniam', 'quis', 'nostrud', 'exercitation', 'ullamco', 'laboris', 'nisi', 'aliquip', 'ex', 'ea', 'commodo', 'consequat', 'duis', 'aute', 'irure', 'in', 'reprehenderit', 'voluptate', 'velit', 'esse', 'cillum', 'fugiat', 'nulla', 'pariatur', 'excepteur', 'sint', 'occaecat', 'cupidatat', 'non', 'proident', 'sunt', 'culpa', 'qui', 'officia', 'deserunt', 'mollit', 'anim', 'id', 'est', 'laborum'];

        function generateLorem() {
            const numParagraphs = parseInt(document.getElementById('paragraphs').value);
            const wordsPerPara = parseInt(document.getElementById('words').value);
            const startWithLorem = document.getElementById('startWithLorem').checked;

            let result = '';

            for (let p = 0; p < numParagraphs; p++) {
                let paragraph = '';

                if (p === 0 && startWithLorem) {
                    paragraph = 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. ';
                }

                for (let w = 0; w < wordsPerPara; w++) {
                    const word = loremWords[Math.floor(Math.random() * loremWords.length)];
                    paragraph += (w === 0 || paragraph.endsWith('. ')) ?
                        word.charAt(0).toUpperCase() + word.slice(1) : word;
                    paragraph += (w < wordsPerPara - 1) ? ' ' : '';

                    if (Math.random() < 0.1 && w < wordsPerPara - 1) {
                        paragraph += '. ';
                    }
                }

                if (!paragraph.endsWith('.')) paragraph += '.';
                result += '<p>' + paragraph + '</p>';
            }

            document.getElementById('loremText').innerHTML = result;
            document.getElementById('output').style.display = 'block';
            document.getElementById('output').scrollIntoView({ behavior: 'smooth', block: 'nearest' });
        }

        function copyOutput() {
            const text = document.getElementById('loremText').innerText;
            copyToClipboard(text);
        }

        generateLorem();
    </script>
@endsection