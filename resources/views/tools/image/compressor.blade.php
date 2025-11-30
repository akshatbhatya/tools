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
            border-radius: var(--radius-xl);
            padding: var(--spacing-2xl);
            text-align: center;
            cursor: pointer;
            transition: all var(--transition-base);
            background: var(--bg-secondary);
        }

        .upload-area:hover,
        .upload-area.dragover {
            border-color: var(--primary-500);
            background: var(--primary-500);
            color: white;
        }

        .quality-slider {
            width: 100%;
            margin: var(--spacing-md) 0;
        }

        .preview-container {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: var(--spacing-lg);
            margin: var(--spacing-xl) 0;
        }

        .preview-item img {
            max-width: 100%;
            border-radius: var(--radius-lg);
        }
    </style>
@endsection

@section('content')
    <div class="tool-container">
        <div class="tool-header">
            <h1><i class="fas fa-file-zipper"></i> {{ $title }}</h1>
            <p>{{ $description }}</p>
        </div>

        <div class="card">
            <div class="upload-area" id="uploadArea" onclick="document.getElementById('imageInput').click()">
                <div style="font-size: 3rem; margin-bottom: var(--spacing-md);"><i class="fas fa-image"></i></div>
                <h3>Click or Drag Image Here</h3>
                <p>Supports JPG, PNG, WebP</p>
                <input type="file" id="imageInput" accept="image/*" style="display: none;">
            </div>

            <div id="controlPanel" style="display: none; margin-top: var(--spacing-xl);">
                <div class="form-group">
                    <label class="form-label">Compression Quality: <span id="qualityValue">80</span>%</label>
                    <input type="range" class="quality-slider" id="qualitySlider" min="1" max="100" value="80">
                </div>

                <div class="preview-container" id="previewContainer"></div>

                <div class="flex gap-md">
                    <button onclick="downloadCompressed()" class="btn btn-primary"><i class="fas fa-download"></i> Download
                        Compressed</button>
                    <button onclick="reset()" class="btn btn-outline"><i class="fas fa-rotate"></i> New Image</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        let originalImage = null;
        let compressedBlob = null;
        let debounceTimer = null;

        const imageInput = document.getElementById('imageInput');
        const uploadArea = document.getElementById('uploadArea');
        const controlPanel = document.getElementById('controlPanel');
        const qualitySlider = document.getElementById('qualitySlider');
        const qualityValue = document.getElementById('qualityValue');
        const previewContainer = document.getElementById('previewContainer');

        // File input change
        imageInput.addEventListener('change', handleImageUpload);

        // Drag and drop
        uploadArea.addEventListener('dragover', (e) => {
            e.preventDefault();
            uploadArea.classList.add('dragover');
        });

        uploadArea.addEventListener('dragleave', () => {
            uploadArea.classList.remove('dragover');
        });

        uploadArea.addEventListener('drop', (e) => {
            e.preventDefault();
            uploadArea.classList.remove('dragover');
            const files = e.dataTransfer.files;
            if (files.length > 0) {
                handleFile(files[0]);
            }
        });

        // Quality slider with debouncing to prevent stuttering
        qualitySlider.addEventListener('input', function () {
            // Update the quality value immediately for smooth feedback
            qualityValue.textContent = this.value;

            if (originalImage) {
                // Clear any existing timer
                if (debounceTimer) {
                    clearTimeout(debounceTimer);
                }

                // Set a new timer to compress after 300ms of no slider movement
                debounceTimer = setTimeout(() => {
                    compressImage();
                }, 300);
            }
        });

        function handleImageUpload() {
            const file = imageInput.files[0];
            if (file) {
                handleFile(file);
            }
        }

        function handleFile(file) {
            if (!file.type.startsWith('image/')) {
                showToast('Please select an image file!', 'error');
                return;
            }

            const reader = new FileReader();
            reader.onload = function (e) {
                const img = new Image();
                img.onload = function () {
                    originalImage = { img, file };
                    compressImage();
                    controlPanel.style.display = 'block';
                };
                img.src = e.target.result;
            };
            reader.readAsDataURL(file);
        }

        function compressImage() {
            const canvas = document.createElement('canvas');
            const ctx = canvas.getContext('2d');

            canvas.width = originalImage.img.width;
            canvas.height = originalImage.img.height;

            ctx.drawImage(originalImage.img, 0, 0);

            const quality = parseInt(qualitySlider.value) / 100;

            canvas.toBlob(function (blob) {
                compressedBlob = blob;
                updatePreview(blob);
            }, 'image/jpeg', quality);
        }

        function updatePreview(compressedBlob) {
            const originalSize = formatFileSize(originalImage.file.size);
            const compressedSize = formatFileSize(compressedBlob.size);
            const savedPercent = Math.round((1 - compressedBlob.size / originalImage.file.size) * 100);

            previewContainer.innerHTML = `
                    <div class="preview-item">
                        <h4>Original Image</h4>
                        <img src="${URL.createObjectURL(originalImage.file)}" alt="Original">
                        <p><strong>Size:</strong> ${originalSize}</p>
                    </div>
                    <div class="preview-item">
                        <h4>Compressed Image</h4>
                        <img src="${URL.createObjectURL(compressedBlob)}" alt="Compressed">
                        <p><strong>Size:</strong> ${compressedSize}</p>
                        <p style="color: var(--accent-500); font-weight: 600;">Saved ${savedPercent}%!</p>
                    </div>
                `;
        }

        function downloadCompressed() {
            if (!compressedBlob) return;

            const url = URL.createObjectURL(compressedBlob);
            const a = document.createElement('a');
            a.href = url;
            a.download = 'compressed_image.jpg';
            document.body.appendChild(a);
            a.click();
            document.body.removeChild(a);
            URL.revokeObjectURL(url);
            showToast('Image downloaded!');
        }

        function reset() {
            originalImage = null;
            compressedBlob = null;
            imageInput.value = '';
            controlPanel.style.display = 'none';
            previewContainer.innerHTML = '';
        }
    </script>
@endsection