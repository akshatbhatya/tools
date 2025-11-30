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

        .upload-area {
            border: 2px dashed var(--gray-300);
            border-radius: var(--radius-lg);
            padding: var(--spacing-2xl);
            text-align: center;
            cursor: pointer;
            transition: all var(--transition-fast);
            background: rgba(255, 255, 255, 0.05);
        }

        .upload-area:hover,
        .upload-area.dragover {
            border-color: var(--primary-500);
            background: rgba(var(--primary-rgb), 0.1);
        }

        .file-list {
            margin: var(--spacing-xl) 0;
            padding: 0;
            list-style: none;
        }

        .file-item {
            background: var(--bg-secondary);
            padding: var(--spacing-md);
            border-radius: var(--radius-md);
            margin-bottom: var(--spacing-sm);
            display: flex;
            justify-content: space-between;
            align-items: center;
            border: 1px solid var(--border-color);
            animation: slideIn 0.3s ease;
        }

        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateY(10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .file-info {
            display: flex;
            align-items: center;
            gap: var(--spacing-md);
        }

        .file-icon {
            font-size: 2rem;
            color: var(--error);
        }

        .btn-remove {
            background: transparent;
            color: var(--text-secondary);
            border: 1px solid var(--border-color);
            padding: var(--spacing-xs) var(--spacing-sm);
            border-radius: var(--radius-sm);
            cursor: pointer;
            transition: all var(--transition-fast);
        }

        .btn-remove:hover {
            background: var(--error);
            color: white;
            border-color: var(--error);
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
            <div class="upload-area" id="uploadArea">
                <div style="font-size: 3rem; margin-bottom: var(--spacing-md); color: var(--text-secondary);">
                    <i class="fas fa-cloud-upload-alt"></i>
                </div>
                <h3>Click or Drag PDFs Here</h3>
                <p style="color: var(--text-secondary);">Select multiple PDF files to merge</p>
                <input type="file" id="pdfInput" accept=".pdf" multiple style="display: none;">
            </div>

            <ul id="fileList" class="file-list"></ul>

            <div id="controls" style="display: none; margin-top: var(--spacing-xl); text-align: center;">
                <div style="display: flex; justify-content: center; gap: var(--spacing-md);">
                    <button onclick="mergePDFs()" class="btn btn-primary">
                        <i class="fas fa-object-group"></i> Merge PDFs
                    </button>
                    <button onclick="clearFiles()" class="btn btn-outline">
                        <i class="fas fa-trash"></i> Clear All
                    </button>
                </div>
            </div>

            <div id="processingMessage" style="display: none; margin-top: var(--spacing-xl); text-align: center;">
                <div class="spinner" style="margin: 0 auto var(--spacing-md);"></div>
                <p>Merging your PDFs... This may take a moment.</p>
            </div>
        </div>

        <div class="card" style="margin-top: var(--spacing-xl);">
            <h3>How to Merge PDFs:</h3>
            <ol style="margin-top: var(--spacing-md); padding-left: var(--spacing-xl);">
                <li>Click the upload area or drag and drop your PDF files</li>
                <li>Files will be merged in the order they appear in the list</li>
                <li>You can remove individual files if needed</li>
                <li>Click "Merge PDFs" to combine them into a single document</li>
                <li>The merged PDF will automatically download</li>
            </ol>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdf-lib/1.17.1/pdf-lib.min.js"></script>
    <script>
        const { PDFDocument } = PDFLib;
        let selectedFiles = [];
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
            uploadArea.addEventListener(eventName, highlight, false);
        });

        ['dragleave', 'drop'].forEach(eventName => {
            uploadArea.addEventListener(eventName, unhighlight, false);
        });

        function highlight(e) {
            uploadArea.classList.add('dragover');
        }

        function unhighlight(e) {
            uploadArea.classList.remove('dragover');
        }

        uploadArea.addEventListener('drop', handleDrop, false);

        function handleDrop(e) {
            const dt = e.dataTransfer;
            const files = dt.files;
            handleFiles(files);
        }

        pdfInput.addEventListener('change', function (e) {
            handleFiles(this.files);
        });

        function handleFiles(files) {
            const newFiles = Array.from(files).filter(file => file.type === 'application/pdf');

            if (newFiles.length === 0 && files.length > 0) {
                showToast('Please select valid PDF files!', 'error');
                return;
            }

            selectedFiles = [...selectedFiles, ...newFiles];
            displayFiles();
        }

        function displayFiles() {
            const fileList = document.getElementById('fileList');
            const controls = document.getElementById('controls');

            fileList.innerHTML = '';

            if (selectedFiles.length === 0) {
                controls.style.display = 'none';
                return;
            }

            controls.style.display = 'block';

            selectedFiles.forEach((file, index) => {
                const li = document.createElement('li');
                li.className = 'file-item';
                li.innerHTML = `
                        <div class="file-info">
                            <span class="file-icon"><i class="fas fa-file-pdf"></i></span>
                            <div>
                                <strong>${file.name}</strong>
                                <br>
                                <small style="color: var(--text-secondary);">${formatFileSize(file.size)}</small>
                            </div>
                        </div>
                        <button onclick="removeFile(${index})" class="btn-remove" title="Remove file">
                            <i class="fas fa-times"></i>
                        </button>
                    `;
                fileList.appendChild(li);
            });
        }

        function removeFile(index) {
            // Stop propagation if triggered from inside upload area (though list is outside)
            event.stopPropagation();
            selectedFiles.splice(index, 1);
            displayFiles();
        }

        function clearFiles() {
            selectedFiles = [];
            pdfInput.value = '';
            displayFiles();
        }

        async function mergePDFs() {
            if (selectedFiles.length < 2) {
                showToast('Please select at least 2 PDF files to merge!', 'error');
                return;
            }

            const processingMsg = document.getElementById('processingMessage');
            const controls = document.getElementById('controls');

            processingMsg.style.display = 'block';
            controls.style.display = 'none';

            try {
                const mergedPdf = await PDFDocument.create();

                for (const file of selectedFiles) {
                    const arrayBuffer = await file.arrayBuffer();
                    const pdf = await PDFDocument.load(arrayBuffer);
                    const copiedPages = await mergedPdf.copyPages(pdf, pdf.getPageIndices());
                    copiedPages.forEach((page) => mergedPdf.addPage(page));
                }

                const mergedPdfBytes = await mergedPdf.save();
                const blob = new Blob([mergedPdfBytes], { type: 'application/pdf' });

                const url = URL.createObjectURL(blob);
                const a = document.createElement('a');
                a.href = url;
                a.download = 'merged-document.pdf';
                document.body.appendChild(a);
                a.click();
                document.body.removeChild(a);
                URL.revokeObjectURL(url);

                showToast('PDFs merged successfully!', 'success');
                clearFiles();
            } catch (error) {
                console.error(error);
                showToast('Error merging PDFs: ' + error.message, 'error');
                controls.style.display = 'block';
            } finally {
                processingMsg.style.display = 'none';
            }
        }
    </script>
@endsection