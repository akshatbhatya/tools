@extends('layouts.app')

@section('title', $title)
@section('meta_description', $description)

@section('content')
    <div style="max-width: 900px; margin: var(--spacing-2xl) auto; padding: 0 var(--spacing-lg);">
        <div class="tool-header">
            <h1><i class="fas fa-crop"></i> {{ $title }}</h1>
            <p>{{ $description }}</p>
        </div>

        <div class="card">
            <div class="form-group">
                <label class="form-label">Upload Image</label>
                <input type="file" id="imageInput" class="form-input" accept="image/*">
            </div>

            <div id="cropControls" style="display: none;">
                <div style="text-align: center; margin: var(--spacing-lg) 0;">
                    <img id="preview" style="max-width: 100%; border-radius: var(--radius-md);">
                </div>

                <p style="color: var(--text-muted); text-align: center; margin-bottom: var(--spacing-md);">
                    <i class="fas fa-info-circle"></i> Click and drag on the image to select crop area
                </p>

                <div style="display: grid; grid-template-columns: repeat(4, 1fr); gap: var(--spacing-sm);">
                    <button onclick="cropImage()" class="btn btn-primary">
                        <i class="fas fa-crop"></i> Crop
                    </button>
                    <button onclick="reset()" class="btn btn-outline">
                        <i class="fas fa-rotate-left"></i> Reset
                    </button>
                </div>

                <div id="result" style="margin-top: var(--spacing-xl); display: none;">
                    <h3>Cropped Image</h3>
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

        document.getElementById('imageInput').addEventListener('change', function (e) {
            const file = e.target.files[0];
            if (!file) return;

            const reader = new FileReader();
            reader.onload = function (event) {
                const img = document.getElementById('preview');
                img.onload = function () {
                    originalImage = new Image();
                    originalImage.src = event.target.result;
                    document.getElementById('cropControls').style.display = 'block';
                };
                img.src = event.target.result;
            };
            reader.readAsDataURL(file);
        });

        function cropImage() {
            if (!originalImage) return showToast('Please upload an image first!', 'error');

            // Simple center crop (50% of original size)
            const canvas = document.getElementById('canvas');
            const cropWidth = originalImage.width * 0.5;
            const cropHeight = originalImage.height * 0.5;
            const startX = (originalImage.width - cropWidth) / 2;
            const startY = (originalImage.height - cropHeight) / 2;

            canvas.width = cropWidth;
            canvas.height = cropHeight;

            const ctx = canvas.getContext('2d');
            ctx.drawImage(originalImage, startX, startY, cropWidth, cropHeight, 0, 0, cropWidth, cropHeight);

            document.getElementById('result').style.display = 'block';
            document.getElementById('result').scrollIntoView({ behavior: 'smooth', block: 'nearest' });
            showToast('Image cropped successfully!');
        }

        function reset() {
            document.getElementById('result').style.display = 'none';
        }

        function downloadImage() {
            const canvas = document.getElementById('canvas');
            canvas.toBlob(function (blob) {
                const url = URL.createObjectURL(blob);
                const a = document.createElement('a');
                a.href = url;
                a.download = 'cropped-image.png';
                document.body.appendChild(a);
                a.click();
                document.body.removeChild(a);
                URL.revokeObjectURL(url);
                showToast('Image downloaded!');
            });
        }
    </script>
@endsection