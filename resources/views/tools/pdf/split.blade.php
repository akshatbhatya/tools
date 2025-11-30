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

        .page-selector {
            margin: var(--spacing-xl) 0;
        }

        .page-range-inputs {
            display: grid;
            grid-template-columns: 1fr auto 1fr;
            gap: var(--spacing-md);
            align-items: center;
            margin: var(--spacing-md) 0;
        }
    </style>
@endsection

@section('content')
    <div class="tool-container">
        <div class="tool-header">
            <h1>✂️ {{ $title }}</h1>
            <p>{{ $description }}</p>
        </div>

        <div class="card">
            <div class="file-upload">
                <div class="upload-area" id="uploadArea" onclick="document.getElementById('pdfInput').click()">
                    <div style="font-size: 3rem; margin-bottom: var(--spacing-md);"><i class="fas fa-file-pdf"></i></div>
                    <h3>Click or Drag PDF Here</h3>
                    <p>Supports PDF files up to 10MB</p>
                    <input type="file" id="pdfInput" accept=".pdf" style="display: none;">
                </div>

                <div id="fileInfo" style="display: none; margin-top: var(--spacing-xl);">
                    <div class="file-item">
                        <span class="file-icon"><i class="fas fa-file-pdf"></i></span>
                        <div class="file-details">
                            <div class="file-name" id="fileName">filename.pdf</div>
                            <div class="file-size" id="fileSize">0 KB</div>
                        </div>
                        <button onclick="reset()" class="btn-icon" title="Remove file"><i class="fas fa-times"></i></button>
                    </div>

                    <div class="split-options">
                        <h3>Split Options</h3>
                        <div class="form-group">
                            <label class="form-label">Page Range (e.g., 1-5, 8, 11-13)</label>
                            <input type="text" id="pageRange" class="form-input" placeholder="1-5">
                            <small style="color: var(--text-secondary); display: block; margin-top: var(--spacing-sm);">
                                Total Pages: <span id="totalPages">0</span>
                            </small>
                        </div>

                        <div class="flex gap-md">
                            <button onclick="splitPDF()" class="btn btn-primary"><i class="fas fa-scissors"></i> Extract
                                Pages</button>
                            <button onclick="reset()" class="btn btn-outline"><i class="fas fa-rotate"></i> New
                                File</button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card" style="margin-top: var(--spacing-xl);">
                <h3>How to Split PDF:</h3>
                <ol style="margin-top: var(--spacing-md); padding-left: var(--spacing-xl);">
                    <li>Upload your PDF file</li>
                    <li>Enter the page range you want to extract</li>
                    <li>Click "Extract Pages"</li>
                    <li>Download the extracted pages as a new PDF</li>
                </ol>
            </div>
        </div>
@endsection

    @section('scripts')
        <script src="https://cdnjs.cloudflare.com/ajax/libs/pdf-lib/1.17.1/pdf-lib.min.js"></script>
        <script>
            const { PDFDocument } = PDFLib;
            let currentPDF = null;
            let totalPages = 0;

            document.getElementById('pdfInput').addEventListener('change', async function (e) {
                const file = e.target.files[0];
                if (!file) return;

                const arrayBuffer = await file.arrayBuffer();
                currentPDF = await PDFDocument.load(arrayBuffer);
                totalPages = currentPDF.getPageCount();

                document.getElementById('pdfInfo').innerHTML = `
                <strong>File:</strong> ${file.name}<br>
                <strong>Total Pages:</strong> ${totalPages}<br>
                <strong>Size:</strong> ${formatFileSize(file.size)}
            `;

                document.getElementById('toPage').max = totalPages;
                document.getElementById('toPage').value = totalPages;
                document.getElementById('fromPage').max = totalPages;

                document.getElementById('splitOptions').style.display = 'block';
            });

            async function splitPDF() {
                if (!currentPDF) {
                    showToast('Please upload a PDF file first!', 'error');
                    return;
                }

                const fromPage = parseInt(document.getElementById('fromPage').value);
                const toPage = parseInt(document.getElementById('toPage').value);

                if (fromPage < 1 || toPage > totalPages || fromPage > toPage) {
                    showToast('Invalid page range!', 'error');
                    return;
                }

                try {
                    const newPdf = await PDFDocument.create();
                    const pagesToExtract = [];

                    for (let i = fromPage - 1; i < toPage; i++) {
                        pagesToExtract.push(i);
                    }

                    const copiedPages = await newPdf.copyPages(currentPDF, pagesToExtract);
                    copiedPages.forEach((page) => newPdf.addPage(page));

                    const pdfBytes = await newPdf.save();
                    const blob = new Blob([pdfBytes], { type: 'application/pdf' });

                    const url = URL.createObjectURL(blob);
                    const a = document.createElement('a');
                    a.href = url;
                    a.download = `extracted_pages_${fromPage}-${toPage}.pdf`;
                    document.body.appendChild(a);
                    a.click();
                    document.body.removeChild(a);
                    URL.revokeObjectURL(url);

                    showToast(`Extracted pages ${fromPage} to ${toPage} successfully!`);
                } catch (error) {
                    showToast('Error splitting PDF: ' + error.message, 'error');
                }
            }

            function reset() {
                currentPDF = null;
                totalPages = 0;
                document.getElementById('pdfInput').value = '';
                document.getElementById('splitOptions').style.display = 'none';
            }
        </script>
    @endsection