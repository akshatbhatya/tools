@extends('layouts.app')

@section('title', $title)
@section('meta_description', $description)

@section('styles')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.css">
    <style>
        .img-container {
            max-width: 100%;
            max-height: 500px;
            margin-bottom: var(--spacing-lg);
        }

        .img-container img {
            max-width: 100%;
            display: block;
        }

        .preview-container {
            overflow: hidden;
            width: 200px;
            height: 200px;
            border-radius: var(--radius-md);
            border: 1px solid var(--border-color);
        }
    </style>
@endsection

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
                <div class="img-container">
                    <img id="image" src="" alt="Picture to crop">
                </div>

                <p style="color: var(--text-muted); text-align: center; margin-bottom: var(--spacing-md);">
                    <i class="fas fa-info-circle"></i> Drag to move, scroll to zoom, drag handles to resize crop area
                </p>

                <div style="display: grid; grid-template-columns: repeat(4, 1fr); gap: var(--spacing-sm);">
                    <button onclick="cropImage()" class="btn btn-primary">
                        <i class="fas fa-crop"></i> Crop
                    </button>
                    <button onclick="reset()" class="btn btn-outline">
                        <i class="fas fa-rotate-left"></i> Reset
                    </button>
                    <button onclick="rotate(-90)" class="btn btn-outline">
                        <i class="fas fa-undo"></i> Rotate Left
                    </button>
                    <button onclick="rotate(90)" class="btn btn-outline">
                        <i class="fas fa-redo"></i> Rotate Right
                    </button>
                </div>

                <div id="result" style="margin-top: var(--spacing-xl); display: none;">
                    <h3>Cropped Image</h3>
                    <div style="text-align: center;">
                        <img id="croppedImage"
                            style="max-width: 100%; border-radius: var(--radius-md); margin-top: var(--spacing-md); box-shadow: var(--shadow-md);">
                    </div>
                    <button onclick="downloadImage()" class="btn btn-primary"
                        style="width: 100%; margin-top: var(--spacing-md);">
                        <i class="fas fa-download"></i> Download
                    </button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.js"></script>
    <script>
        let cropper = null;
        const image = document.getElementById('image');
        const input = document.getElementById('imageInput');

        input.addEventListener('change', function (e) {
            const file = e.target.files[0];
            if (!file) return;

            const reader = new FileReader();
            reader.onload = function (event) {
                // Destroy existing cropper if any
                if (cropper) {
                    cropper.destroy();
                    cropper = null;
                }

                image.src = event.target.result;
                document.getElementById('cropControls').style.display = 'block';
                document.getElementById('result').style.display = 'none';

                // Initialize cropper after image loads
                image.onload = function () {
                    cropper = new Cropper(image, {
                        aspectRatio: NaN, // Free crop
                        viewMode: 1,
                        dragMode: 'move',
                        autoCropArea: 0.8,
                        restore: false,
                        guides: true,
                        center: true,
                        highlight: true,
                        cropBoxMovable: true,
                        cropBoxResizable: true,
                        toggleDragModeOnDblclick: false,
                    });
                };
            };
            reader.readAsDataURL(file);
        });

        function cropImage() {
            if (!cropper) return;

            const canvas = cropper.getCroppedCanvas();
            if (!canvas) {
                showToast('Could not crop image', 'error');
                return;
            }

            const croppedImage = document.getElementById('croppedImage');
            croppedImage.src = canvas.toDataURL();

            document.getElementById('result').style.display = 'block';
            document.getElementById('result').scrollIntoView({ behavior: 'smooth', block: 'nearest' });
            showToast('Image cropped successfully!');
        }

        function rotate(degree) {
            if (cropper) {
                cropper.rotate(degree);
            }
        }

        function reset() {
            if (cropper) {
                cropper.reset();
                document.getElementById('result').style.display = 'none';
            }
        }

        function downloadImage() {
            const croppedImage = document.getElementById('croppedImage');
            if (!croppedImage.src) return;

            const link = document.createElement('a');
            link.download = 'cropped-image.png';
            link.href = croppedImage.src;
            document.body.appendChild(link);
            link.click();
            document.body.removeChild(link);
            showToast('Image downloaded!');
        }
    </script>
@endsection