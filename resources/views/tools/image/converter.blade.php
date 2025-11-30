@extends('layouts.app')

@section('title', $title)
@section('meta_description', $description)

@section('content')
    <div style="max-width: 800px; margin: var(--spacing-2xl) auto; padding: 0 var(--spacing-lg);">
        <div class="tool-header">
            <h1><i class="fas fa-repeat"></i> {{ $title }}</h1>
            <p>{{ $description }}</p>
        </div>

        <div class="card">
            <div class="form-group">
                <label class="form-label">Upload Image</label>
                <input type="file" id="imageInput" class="form-input" accept="image/*">
            </div>

            <div id="convertControls" style="display: none;">
                <div class="form-group">
                    <label class="form-label">Convert To</label>
                    <select id="format" class="form-select">
                        <option value="image/png">PNG</option>
                        <option value="image/jpeg">JPEG</option>
                        <option value="image/webp">WebP</option>
                    </select>
                </div>

                <div id="qualityControl" style="display: none;">
                    <div class="form-group">
                        <label class="form-label">Quality (0-100)</label>
                        <input type="range" id="quality" class="form-input" min="0" max="100" value="90"
                            style="width: 100%;">
                        <span id="qualityValue">90</span>%
                    </div>
                </div>

                <button onclick="convertImage()" class="btn btn-primary" style="width: 100%;">
                    <i class="fas fa-repeat"></i> Convert Image
                </button>

                <div id="result" style="margin-top: var(--spacing-xl); display: none;">
                    <h3>Converted Image</h3>
                    <canvas id="canvas"
                        style="max-width: 100%; border-radius: var(--radius-md); margin-top: var(--spacing-md);"></canvas>
                    <button onclick="downloadImage()" class="btn btn-primary"
                        style="width: 100%; margin-top: var(--spacing-md);">
                        <i class="fas fa-download"></i> Download
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script>
        let originalImage = null;
        let currentFormat = 'png';

        document.getElementById('format').addEventListener('change', function () {
            currentFormat = this.value.split('/')[1];
            document.getElementById('qualityControl').style.display =
                (this.value === 'image/jpeg' || this.value === 'image/webp') ? 'block' : 'none';
        });

        document.getElementById('quality').addEventListener('input', function () {
            document.getElementById('qualityValue').textContent = this.value;
        });

        document.getElementById('imageInput').addEventListener('change', function (e) {
            const file = e.target.files[0];
            if (!file) return;

            const reader = new FileReader();
            reader.onload = function (event) {
                const img = new Image();
                img.onload = function () {
                    originalImage = img;
                    document.getElementById('convertControls').style.display = 'block';
                };
                img.src = event.target.result;
            };
            reader.readAsDataURL(file);
        });

        function convertImage() {
            if (!originalImage) return showToast('Please upload an image first!', 'error');

            const canvas = document.getElementById('canvas');
            canvas.width = originalImage.width;
            canvas.height = originalImage.height;

            const ctx = canvas.getContext('2d');
            ctx.drawImage(originalImage, 0, 0);

            document.getElementById('result').style.display = 'block';
            document.getElementById('result').scrollIntoView({ behavior: 'smooth', block: 'nearest' });
            showToast('Image converted successfully!');
        }

        function downloadImage() {
            const canvas = document.getElementById('canvas');
            const format = document.getElementById('format').value;
            const quality = parseInt(document.getElementById('quality').value) / 100;

            canvas.toBlob(function (blob) {
                const url = URL.createObjectURL(blob);
                const a = document.createElement('a');
                a.href = url;
                a.download = `converted-image.${currentFormat}`;
                document.body.appendChild(a);
                a.click();
                document.body.removeChild(a);
                URL.revokeObjectURL(url);
                showToast('Image downloaded!');
            }, format, quality);
        }
    </script>
@endsection