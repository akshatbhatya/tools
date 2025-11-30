@extends('layouts.app')

@section('title', $title)
@section('meta_description', $description)

@section('content')
    <div style="max-width: 1000px; margin: var(--spacing-2xl) auto; padding: 0 var(--spacing-lg);">
        <div class="tool-header">
            <h1><i class="fas fa-wand-magic-sparkles"></i> {{ $title }}</h1>
            <p>{{ $description }}</p>
        </div>

        <div class="card">
            <div class="form-group">
                <label class="form-label">Upload Image</label>
                <input type="file" id="imageInput" class="form-input" accept="image/*">
            </div>

            <div id="enhanceControls" style="display: none;">
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: var(--spacing-lg);">
                    <div>
                        <h3>Original Image</h3>
                        <canvas id="original"
                            style="max-width: 100%; border-radius: var(--radius-md); border: 2px solid var(--border-glass);"></canvas>
                    </div>
                    <div>
                        <h3>Enhanced Image</h3>
                        <canvas id="enhanced"
                            style="max-width: 100%; border-radius: var(--radius-md); border: 2px solid var(--neon-primary);"></canvas>
                    </div>
                </div>

                <div style="margin-top: var(--spacing-lg);">
                    <div class="form-group">
                        <label class="form-label">Brightness: <span id="brightnessValue">1.0</span></label>
                        <input type="range" id="brightness" class="form-input" min="0.5" max="2" value="1" step="0.1"
                            style="width: 100%;">
                    </div>

                    <div class="form-group">
                        <label class="form-label">Contrast: <span id="contrastValue">1.0</span></label>
                        <input type="range" id="contrast" class="form-input" min="0.5" max="2" value="1" step="0.1"
                            style="width: 100%;">
                    </div>

                    <div class="form-group">
                        <label class="form-label">Saturation: <span id="saturationValue">1.0</span></label>
                        <input type="range" id="saturation" class="form-input" min="0" max="2" value="1" step="0.1"
                            style="width: 100%;">
                    </div>

                    <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: var(--spacing-sm);">
                        <button onclick="autoEnhance()" class="btn btn-primary">
                            <i class="fas fa-magic"></i> Auto Enhance
                        </button>
                        <button onclick="resetFilters()" class="btn btn-outline">
                            <i class="fas fa-rotate-left"></i> Reset
                        </button>
                        <button onclick="downloadImage()" class="btn btn-primary">
                            <i class="fas fa-download"></i> Download
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        let originalImage = null;
        let originalCanvas = null;
        let enhancedCanvas = null;

        document.getElementById('imageInput').addEventListener('change', function (e) {
            const file = e.target.files[0];
            if (!file) return;

            const reader = new FileReader();
            reader.onload = function (event) {
                const img = new Image();
                img.onload = function () {
                    originalImage = img;
                    originalCanvas = document.getElementById('original');
                    enhancedCanvas = document.getElementById('enhanced');

                    originalCanvas.width = img.width;
                    originalCanvas.height = img.height;
                    enhancedCanvas.width = img.width;
                    enhancedCanvas.height = img.height;

                    const ctx = originalCanvas.getContext('2d');
                    ctx.drawImage(img, 0, 0);

                    document.getElementById('enhanceControls').style.display = 'block';
                    applyFilters();
                };
                img.src = event.target.result;
            };
            reader.readAsDataURL(file);
        });

        ['brightness', 'contrast', 'saturation'].forEach(id => {
            document.getElementById(id).addEventListener('input', function () {
                document.getElementById(id + 'Value').textContent = this.value;
                applyFilters();
            });
        });

        function applyFilters() {
            if (!originalImage) return;

            const brightness = parseFloat(document.getElementById('brightness').value);
            const contrast = parseFloat(document.getElementById('contrast').value);
            const saturation = parseFloat(document.getElementById('saturation').value);

            const ctx = enhancedCanvas.getContext('2d');
            ctx.filter = `brightness(${brightness}) contrast(${contrast}) saturate(${saturation})`;
            ctx.drawImage(originalImage, 0, 0);
        }

        function autoEnhance() {
            document.getElementById('brightness').value = 1.1;
            document.getElementById('contrast').value = 1.2;
            document.getElementById('saturation').value = 1.1;
            document.getElementById('brightnessValue').textContent = '1.1';
            document.getElementById('contrastValue').textContent = '1.2';
            document.getElementById('saturationValue').textContent = '1.1';
            applyFilters();
            showToast('Auto enhancement applied!');
        }

        function resetFilters() {
            document.getElementById('brightness').value = 1;
            document.getElementById('contrast').value = 1;
            document.getElementById('saturation').value = 1;
            document.getElementById('brightnessValue').textContent = '1.0';
            document.getElementById('contrastValue').textContent = '1.0';
            document.getElementById('saturationValue').textContent = '1.0';
            applyFilters();
        }

        function downloadImage() {
            enhancedCanvas.toBlob(function (blob) {
                const url = URL.createObjectURL(blob);
                const a = document.createElement('a');
                a.href = url;
                a.download = 'enhanced-image.png';
                document.body.appendChild(a);
                a.click();
                document.body.removeChild(a);
                URL.revokeObjectURL(url);
                showToast('Image downloaded!');
            });
        }
    </script>
@endsection