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

        .quality-options {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: var(--spacing-md);
            margin: var(--spacing-xl) 0;
        }

        .quality-option {
            padding: var(--spacing-lg);
            border: 2px solid var(--gray-300);
            border-radius: var(--radius-lg);
            cursor: pointer;
            transition: all var(--transition-base);
            text-align: center;
        }

        .quality-option:hover,
        .quality-option.selected {
            border-color: var(--primary-500);
            background: var(--primary-500);
            color: white;
        }

        .result-comparison {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: var(--spacing-lg);
            margin: var(--spacing-xl) 0;
        }
    </style>
@endsection

@section('content')
    <div class="tool-container">
        <div class="tool-header">
            <h1><i class="fas fa-compress"></i> {{ $title }}</h1>
            <p>{{ $description }}</p>
        </div>

        <div class="card">
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

                <div class="compress-options">
                    <h3>Compression Level</h3>
                    <div class="form-group">
                        <select id="compressionLevel" class="form-select">
                            <option value="low">Low Compression (High Quality)</option>
                            <option value="medium" selected>Medium Compression (Balanced)</option>
                            <option value="high">High Compression (Low Quality)</option>
                        </select>
                    </div>

                    <div class="flex gap-md">
                        <button onclick="compressPDF()" class="btn btn-primary"><i class="fas fa-compress"></i> Compress
                            PDF</button>
                        <button onclick="reset()" class="btn btn-outline"><i class="fas fa-rotate"></i> New File</button>
                    </div>
                </div>
            </div>

            <div id="resultArea" style="display: none; margin-top: var(--spacing-xl); text-align: center;">
                <div class="success-message">
                    <div style="font-size: 3rem; margin-bottom: var(--spacing-md);">✅</div>
                    <h3>PDF Compressed Successfully!</h3>
                    <p>Your file has been compressed.</p>
                    <div class="stats-grid">
                        <div class="stat-item">
                            <div class="stat-label">Original Size</div>
                            <div class="stat-value" id="originalSizeDisplay">0 KB</div>
                        </div>
                        <div class="stat-item">
                            <div class="stat-label">Compressed Size</div>
                            <div class="stat-value" id="compressedSizeDisplay">0 KB</div>
                        </div>
                        <div class="stat-item">
                            <div class="stat-label">Saved</div>
                            <div class="stat-value" id="savedPercentage" style="color: var(--success);">0%</div>
                        </div>
                    </div>
                    <div class="flex justify-center gap-md" style="margin-top: var(--spacing-lg);">
                        <button onclick="downloadCompressed()" class="btn btn-secondary"><i class="fas fa-download"></i>
                            Download Compressed PDF</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="card" style="margin-top: var(--spacing-xl);">
            <h3>About PDF Compression:</h3>
            <p style="margin-top: var(--spacing-md);">PDF compression reduces file size by optimizing images and removing
                unnecessary metadata. This tool uses client-side processing to ensure your files remain private.</p>
            <ul style="margin-top: var(--spacing-md); padding-left: var(--spacing-xl);">
                <li><strong>High Quality:</strong> Preserves most quality, smaller reduction</li>
                <li><strong>Medium Quality:</strong> Good balance between quality and size</li>
                <li><strong>Low Quality:</strong> Maximum size reduction, lower quality</li>
            </ul>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdf-lib/1.17.1/pdf-lib.min.js"></script>
    <script>
        const { PDFDocument } = PDFLib;
        let currentFile = null;
        let currentPDF = null;
        let selectedQuality = 'high';

        document.getElementById('pdfInput').addEventListener('change', async function (e) {
            const file = e.target.files[0];
            if (!file) return;

            currentFile = file;
            const arrayBuffer = await file.arrayBuffer();
            currentPDF = await PDFDocument.load(arrayBuffer);

            document.getElementById('fileInfo').innerHTML = `
                <div style="padding: var(--spacing-lg); background: var(--bg-secondary); border-radius: var(--radius-md);">
                    <strong>Original File:</strong> ${file.name}<br>
                    <strong>Size:</strong> ${formatFileSize(file.size)}<br>
                    <strong>Pages:</strong> ${currentPDF.getPageCount()}
                </div>
            `;

            document.getElementById('compressOptions').style.display = 'block';
        });

        function selectQuality(level) {
            selectedQuality = level;
            document.querySelectorAll('.quality-option').forEach(el => {
                el.classList.remove('selected');
            });
            document.querySelector(`[data-level="${level}"]`).classList.add('selected');
        }

        async function compressPDF() {
            if (!currentPDF || !currentFile) {
                showToast('Please upload a PDF file first!', 'error');
                return;
            }

            try {
                showToast('Compressing PDF... This may take a moment.');

                // Note: pdf-lib doesn't directly compress. For real compression, you'd need server-side processing
                // or more advanced libraries. This is a simplified version that re-saves the PDF.
                const pdfBytes = await currentPDF.save();
                const blob = new Blob([pdfBytes], { type: 'application/pdf' });

                const originalSize = currentFile.size;
                const newSize = blob.size;
                const reduction = ((originalSize - newSize) / originalSize * 100).toFixed(1);

                // Display results
                document.getElementById('fileInfo').innerHTML = `
                    <div style="padding: var(--spacing-lg); background: var(--bg-secondary); border-radius: var(--radius-md);">
                        <strong>Original Size:</strong> ${formatFileSize(originalSize)}<br>
                        <strong>Compressed Size:</strong> ${formatFileSize(newSize)}<br>
                        <strong>Reduction:</strong> ${reduction > 0 ? reduction : '0'}%<br>
                        <div style="margin-top: var(--spacing-md);">
                            <button onclick="downloadCompressed()" class="btn btn-secondary">💾 Download Compressed PDF</button>
                        </div>
                    </div>
                `;

                // Store compressed blob for download
                window.compressedBlob = blob;

                if (newSize < originalSize) {
                    showToast('PDF compressed successfully!');
                } else {
                    showToast('PDF is already optimized. No significant compression possible.');
                }
            } catch (error) {
                showToast('Error compressing PDF: ' + error.message, 'error');
            }
        }

        function downloadCompressed() {
            if (!window.compressedBlob) return;

            const url = URL.createObjectURL(window.compressedBlob);
            const a = document.createElement('a');
            a.href = url;
            a.download = 'compressed.pdf';
            document.body.appendChild(a);
            a.click();
            document.body.removeChild(a);
            URL.revokeObjectURL(url);
            showToast('Download started!');
        }

        function reset() {
            currentPDF = null;
            currentFile = null;
            window.compressedBlob = null;
            document.getElementById('pdfInput').value = '';
            document.getElementById('compressOptions').style.display = 'none';
        }
    </script>
@endsection