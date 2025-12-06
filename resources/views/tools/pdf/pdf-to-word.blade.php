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
            background: var(--gradient-accent);
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
            <h1><i class="fas fa-file-word"></i> {{ $title }}</h1>
            <p>{{ $description }}</p>
        </div>

        <div class="card">
            <div class="upload-area" id="uploadArea"
                style="border: 2px dashed var(--gray-300); border-radius: var(--radius-lg); padding: var(--spacing-2xl); text-align: center; cursor: pointer; transition: all var(--transition-fast); background: rgba(255, 255, 255, 0.05);">
                <div style="font-size: 3rem; margin-bottom: var(--spacing-md); color: var(--text-secondary);">
                    <i class="fas fa-file-pdf"></i>
                </div>
                <h3>Click or Drag PDF Here</h3>
                <p style="color: var(--text-secondary);">Upload a PDF file to extract text</p>
                <input type="file" id="pdfInput" accept=".pdf" style="display: none;">
            </div>

            <div id="extractOptions" style="display: none;">
                <div id="fileInfo" style="margin: var(--spacing-xl) 0;">
                </div>

                <button onclick="extractText()" class="btn btn-primary" style="width: 100%;">📝 Extract Text as TXT</button>
                <p style="margin-top: var(--spacing-md); color: var(--text-secondary); font-size: 0.9rem;">
                    Note: This extracts plain text from PDF. For full formatting preservation, use professional conversion
                    tools mentioned above.
                </p>
            </div>
        </div>

        <div class="card" style="margin-top: var(--spacing-xl);">
            <h3>How to Convert PDF to Text:</h3>
            <ol style="margin-top: var(--spacing-md); padding-left: var(--spacing-xl);">
                <li>Click the upload area or drag and drop your PDF file</li>
                <li>Wait for the file to be processed</li>
                <li>Click "Extract Text as TXT" to download the text file</li>
                <li>The text will be extracted from all pages of the PDF</li>
            </ol>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.11.174/pdf.min.js"></script>
    <script>
        pdfjsLib.GlobalWorkerOptions.workerSrc = 'https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.11.174/pdf.worker.min.js';

        let currentPDF = null;
        let pdfDoc = null;

        const uploadArea = document.getElementById('uploadArea');
        const pdfInput = document.getElementById('pdfInput');

        // Click to upload
        uploadArea.addEventListener('click', () => pdfInput.click());

        // Drag and drop support
        ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
            uploadArea.addEventListener(eventName, preventDefaults, false);
        });

        function preventDefaults(e) {
            e.preventDefault();
            e.stopPropagation();
        }

        ['dragenter', 'dragover'].forEach(eventName => {
            uploadArea.addEventListener(eventName, () => {
                uploadArea.style.borderColor = 'var(--primary-500)';
                uploadArea.style.background = 'rgba(var(--primary-rgb), 0.1)';
            }, false);
        });

        ['dragleave', 'drop'].forEach(eventName => {
            uploadArea.addEventListener(eventName, () => {
                uploadArea.style.borderColor = 'var(--gray-300)';
                uploadArea.style.background = 'rgba(255, 255, 255, 0.05)';
            }, false);
        });

        uploadArea.addEventListener('drop', function (e) {
            const dt = e.dataTransfer;
            const files = dt.files;
            if (files.length > 0) {
                pdfInput.files = files;
                pdfInput.dispatchEvent(new Event('change'));
            }
        }, false);

        document.getElementById('pdfInput').addEventListener('change', async function (e) {
            const file = e.target.files[0];
            if (!file) return;

            currentPDF = file;
            const arrayBuffer = await file.arrayBuffer();
            pdfDoc = await pdfjsLib.getDocument({ data: arrayBuffer }).promise;

            document.getElementById('fileInfo').innerHTML = `
                        <div style="padding: var(--spacing-lg); background: var(--bg-secondary); border-radius: var(--radius-md);">
                            <strong>File:</strong> ${file.name}<br>
                            <strong>Size:</strong> ${formatFileSize(file.size)}<br>
                            <strong>Pages:</strong> ${pdfDoc.numPages}
                        </div>
                    `;

            document.getElementById('extractOptions').style.display = 'block';
        });

        async function extractText() {
            if (!pdfDoc) {
                showToast('Please upload a PDF file first!', 'error');
                return;
            }

            try {
                showToast('Extracting text from PDF...');
                let fullText = '';

                for (let i = 1; i <= pdfDoc.numPages; i++) {
                    const page = await pdfDoc.getPage(i);
                    const textContent = await page.getTextContent();
                    const pageText = textContent.items.map(item => item.str).join(' ');
                    fullText += `\n\n--- Page ${i} ---\n\n${pageText}`;
                }

                // Create and download text file
                const blob = new Blob([fullText], { type: 'text/plain' });
                const url = URL.createObjectURL(blob);
                const a = document.createElement('a');
                a.href = url;
                a.download = currentPDF.name.replace('.pdf', '.txt');
                document.body.appendChild(a);
                a.click();
                document.body.removeChild(a);
                URL.revokeObjectURL(url);

                showToast('Text extracted successfully!');
            } catch (error) {
                showToast('Error extracting text: ' + error.message, 'error');
            }
        }
    </script>
@endsection