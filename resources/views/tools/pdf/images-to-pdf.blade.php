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

        .image-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(150px, 1fr));
            gap: var(--spacing-md);
            margin: var(--spacing-xl) 0;
        }

        .image-item {
            position: relative;
            border-radius: var(--radius-md);
            overflow: hidden;
            border: 2px solid var(--gray-300);
        }

        .image-item img {
            width: 100%;
            height: 150px;
            object-fit: cover;
            display: block;
        }

        .image-remove {
            position: absolute;
            top: 5px;
            right: 5px;
            background: #ff4444;
            color: white;
            border: none;
            border-radius: 50%;
            width: 30px;
            height: 30px;
            cursor: pointer;
            font-size: 1.2rem;
            line-height: 1;
        }
    </style>
@endsection

@section('content')
    <div class="tool-container">
        <div class="tool-header">
            <h1>🖼️ {{ $title }}</h1>
            <p>{{ $description }}</p>
        </div>

        <div class="card">
            <div class="file-upload">
                <div class="upload-area" id="uploadArea" onclick="document.getElementById('imageInput').click()">
                    <div style="font-size: 3rem; margin-bottom: var(--spacing-md);"><i class="fas fa-image"></i></div>
                    <h3>Click or Drag Images Here</h3>
                    <p>Supports JPG, PNG (Max 20 images)</p>
                    <input type="file" id="imageInput" accept="image/*" multiple style="display: none;">
                </div>

                <div id="fileList" class="file-list"></div>

                <div id="controls" style="display: none; margin-top: var(--spacing-xl);">
                    <div class="flex gap-md">
                        <button onclick="createPDF()" class="btn btn-primary"><i class="fas fa-file-pdf"></i> Create
                            PDF</button>
                        <button onclick="clearImages()" class="btn btn-outline"><i class="fas fa-trash"></i> Clear
                            All</button>
                    </div>
                </div>
            </div>

            <div class="card" style="margin-top: var(--spacing-xl);">
                <h3>How to Create PDF from Images:</h3>
                <ol style="margin-top: var(--spacing-md); padding-left: var(--spacing-xl);">
                    <li>Click the upload area and select multiple images</li>
                    <li>Images will appear in the order selected</li>
                    <li>Remove unwanted images by clicking the ✕ button</li>
                    <li>Click "Create PDF" to generate your PDF</li>
                    <li>Each image will be on a separate page</li>
                </ol>
            </div>
        </div>
@endsection

    @section('scripts')
        <script src="https://cdnjs.cloudflare.com/ajax/libs/pdf-lib/1.17.1/pdf-lib.min.js"></script>
        <script>
            const { PDFDocument } = PDFLib;
            let selectedImages = [];

            document.getElementById('imageInput').addEventListener('change', function (e) {
                const files = Array.from(e.target.files);
                files.forEach(file => {
                    if (file.type.startsWith('image/')) {
                        const reader = new FileReader();
                        reader.onload = function (event) {
                            selectedImages.push({
                                file: file,
                                dataUrl: event.target.result
                            });
                            displayImages();
                        };
                        reader.readAsDataURL(file);
                    }
                });
            });

            function displayImages() {
                if (selectedImages.length === 0) {
                    document.getElementById('imageContainer').style.display = 'none';
                    return;
                }

                document.getElementById('imageContainer').style.display = 'block';
                const grid = document.getElementById('imageGrid');
                grid.innerHTML = '';

                selectedImages.forEach((img, index) => {
                    const div = document.createElement('div');
                    div.className = 'image-item';
                    div.innerHTML = `
                    <img src="${img.dataUrl}" alt="${img.file.name}">
                    <button class="image-remove" onclick="removeImage(${index})">✕</button>
                `;
                    grid.appendChild(div);
                });
            }

            function removeImage(index) {
                selectedImages.splice(index, 1);
                displayImages();
            }

            function clearImages() {
                selectedImages = [];
                document.getElementById('imageInput').value = '';
                displayImages();
            }

            async function createPDF() {
                if (selectedImages.length === 0) {
                    showToast('Please select at least one image!', 'error');
                    return;
                }

                try {
                    showToast('Creating PDF... Please wait.');

                    const pdfDoc = await PDFDocument.create();

                    for (const img of selectedImages) {
                        let image;

                        // Embed the image based on type
                        if (img.file.type === 'image/png') {
                            image = await pdfDoc.embedPng(img.dataUrl);
                        } else {
                            image = await pdfDoc.embedJpg(img.dataUrl);
                        }

                        // Create a page with dimensions matching the image
                        const page = pdfDoc.addPage([image.width, image.height]);

                        // Draw the image on the page
                        page.drawImage(image, {
                            x: 0,
                            y: 0,
                            width: image.width,
                            height: image.height,
                        });
                    }

                    const pdfBytes = await pdfDoc.save();
                    const blob = new Blob([pdfBytes], { type: 'application/pdf' });

                    const url = URL.createObjectURL(blob);
                    const a = document.createElement('a');
                    a.href = url;
                    a.download = 'images-to-pdf.pdf';
                    document.body.appendChild(a);
                    a.click();
                    document.body.removeChild(a);
                    URL.revokeObjectURL(url);

                    showToast(`PDF created with ${selectedImages.length} image(s)!`);
                } catch (error) {
                    console.error(error);
                    showToast('Error creating PDF: ' + error.message, 'error');
                }
            }
        </script>
    @endsection