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

        .info-box {
            background: var(--gradient-warm);
            color: white;
            padding: var(--spacing-lg);
            border-radius: var(--radius-lg);
            margin: var(--spacing-xl) 0;
        }
    </style>
@endsection

@section('content')
    <div class="tool-container">
        <div class="tool-header">
            <h1><i class="fas fa-file-pdf"></i> {{ $title }}</h1>
            <p>{{ $description }}</p>
        </div>

        <div class="card">
            <div class="alert alert-warning">
                <h3 style="color: white; margin-bottom: var(--spacing-md);"><i class="fas fa-triangle-exclamation"></i>
                    Browser Limitation</h3>
                <p>Direct Word to PDF conversion is not possible purely in the browser due to complexity. We recommend using
                    the following free and secure methods:</p>
            </div>

            <div class="grid grid-cols-2" style="margin-top: var(--spacing-xl);">
                <div class="method-card" onclick="window.open('https://docs.google.com', '_blank')">
                    <div style="font-size: 3rem; margin-bottom: var(--spacing-md);"><i class="fas fa-file-lines"></i></div>
                </div>
            </div>

            <div class="file-upload">
                <input type="file" id="docInput" class="file-upload-input" accept=".doc,.docx">
                <label for="docInput" class="file-upload-label">
                    <div style="font-size: 3rem;">📝</div>
                    <div>
                        <h3 style="margin-bottom: var(--spacing-sm);">Upload Word Document</h3>
                        <p>To convert using external services</p>
                    </div>
                </label>
            </div>

            <div id="uploadInfo" style="display: none; margin-top: var(--spacing-xl);">
                <div style="padding: var(--spacing-lg); background: var(--bg-secondary); border-radius: var(--radius-md);">
                    <h3>Alternative Methods:</h3>
                    <ol style="margin-top: var(--spacing-md); padding-left: var(--spacing-xl);">
                        <li><strong>Microsoft Word:</strong> Open document → File → Save As → PDF</li>
                        <li><strong>Google Docs:</strong> Upload → File → Download → PDF Document</li>
                        <li><strong>LibreOffice:</strong> File → Export as PDF</li>
                    </ol>

                    <h3 style="margin-top: var(--spacing-xl);">Recommended Online Tools:</h3>
                    <ul style="margin-top: var(--spacing-md); padding-left: var(--spacing-xl);">
                        <li><a href="https://www.ilovepdf.com/word_to_pdf" target="_blank"
                                style="color: var(--primary-500);">iLovePDF</a></li>
                        <li><a href="https://smallpdf.com/word-to-pdf" target="_blank"
                                style="color: var(--primary-500);">Smallpdf</a></li>
                        <li><a href="https://www.adobe.com/acrobat/online/word-to-pdf.html" target="_blank"
                                style="color: var(--primary-500);">Adobe Acrobat</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        document.getElementById('docInput').addEventListener('change', function (e) {
            const file = e.target.files[0];
            if (file) {
                document.getElementById('uploadInfo').style.display = 'block';
                showToast('Please use one of the methods shown below to convert your file.');
            }
        });
    </script>
@endsection