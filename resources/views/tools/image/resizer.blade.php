@extends('layouts.app')

@section('title', $title)
@section('meta_description', $description)

@section('content')
    <div style="max-width: 900px; margin: var(--spacing-2xl) auto; padding: 0 var(--spacing-lg);">
        <div class="tool-header">
            <h1><i class="fas fa-expand"></i> {{ $title }}</h1>
            <p>{{ $description }}</p>
        </div>

        <div class="card">
            <div class="form-group">
                <label class="form-label">Upload Image</label>
                <input type="file" id="imageInput" class="form-input" accept="image/*">
            </div>

            <div id="resizeControls" style="display: none;">
                <div
                    style="display: grid; grid-template-columns: 1fr 1fr; gap: var(--spacing-md); margin-top: var(--spacing-md);">
                    <div class="form-group">
                        <label class="form-label">Width (px)</label>
                        <input type="number" id="width" class="form-input" min="1">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Height (px)</label>
                        <input type="number" id="height" class="form-input" min="1">
                    </div>
                </div>

                <div class="form-group">
                    <label class="checkbox-label">
                        <input type="checkbox" id="maintainAspect" checked> Maintain aspect ratio
                    </label>
                </div>

                <button onclick="resizeImage()" class="btn btn-primary" style="width: 100%;">
                    <i class="fas fa-expand"></i> Resize Image
                </button>

                <div id="result" style="margin-top: var(--spacing-xl); display: none;">
                    <h3>Resized Image</h3>
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
                const img = new Image();
                img.onload = function () {
                    originalImage = img;
                    document.getElementById('width').value = img.width;
                    document.getElementById('height').value = img.height;
                    document.getElementById('resizeControls').style.display = 'block';
                };
                img.src = event.target.result;
            };
            reader.readAsDataURL(file);
        });

        document.getElementById('width').addEventListener('input', function () {
            if (document.getElementById('maintainAspect').checked && originalImage) {
                const aspectRatio = originalImage.height / originalImage.width;
                document.getElementById('height').value = Math.round(this.value * aspectRatio);
            }
        });

        document.getElementById('height').addEventListener('input', function () {
            if (document.getElementById('maintainAspect').checked && originalImage) {
                const aspectRatio = originalImage.width / originalImage.height;
                document.getElementById('width').value = Math.round(this.value * aspectRatio);
            }
        });

        function resizeImage() {
            if (!originalImage) return showToast('Please upload an image first!', 'error');

            const width = parseInt(document.getElementById('width').value);
            const height = parseInt(document.getElementById('height').value);

            const canvas = document.getElementById('canvas');
            canvas.width = width;
            canvas.height = height;

            const ctx = canvas.getContext('2d');
            ctx.drawImage(originalImage, 0, 0, width, height);

            document.getElementById('result').style.display = 'block';
            document.getElementById('result').scrollIntoView({ behavior: 'smooth', block: 'nearest' });
            showToast('Image resized successfully!');
        }

        function downloadImage() {
            const canvas = document.getElementById('canvas');
            canvas.toBlob(function (blob) {
                const url = URL.createObjectURL(blob);
                const a = document.createElement('a');
                a.href = url;
                a.download = 'resized-image.png';
                document.body.appendChild(a);
                a.click();
                document.body.removeChild(a);
                URL.revokeObjectURL(url);
                showToast('Image downloaded!');
            });
        }
    </script>
@endsection