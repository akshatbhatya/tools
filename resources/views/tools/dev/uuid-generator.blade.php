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

        .generator-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: var(--spacing-md);
            margin: var(--spacing-lg) 0;
        }

        .uuid-item {
            background: var(--bg-secondary);
            padding: var(--spacing-md);
            border-radius: var(--radius-md);
            font-family: 'Courier New', monospace;
            font-size: 0.9rem;
            word-break: break-all;
            border: 2px solid var(--gray-300);
            position: relative;
            cursor: pointer;
            transition: all var(--transition-fast);
        }

        .uuid-item:hover {
            border-color: var(--primary-500);
            background: var(--primary-500);
            color: white;
        }

        /* New styles for the updated layout */
        .uuid-list {
            display: flex;
            flex-direction: column;
            gap: var(--spacing-sm);
            max-height: 400px;
            /* Or adjust as needed */
            overflow-y: auto;
            border: 1px solid var(--gray-200);
            border-radius: var(--radius-md);
            padding: var(--spacing-md);
            background-color: var(--bg-secondary);
        }

        .uuid-list .uuid-item {
            margin: 0;
            padding: var(--spacing-xs) var(--spacing-sm);
            border: 1px solid var(--gray-300);
            background: var(--bg-primary);
        }

        .uuid-list .uuid-item:hover {
            border-color: var(--primary-500);
            background: var(--primary-500);
            color: white;
        }
    </style>
@endsection

@section('content')
    <div class="tool-container">
        <div class="tool-header">
            <h1><i class="fas fa-fingerprint"></i> {{ $title }}</h1>
            <p>{{ $description }}</p>
        </div>

        <div class="card">
            <div class="grid grid-cols-2 gap-xl">
                <div>
                    <div class="form-group">
                        <label class="form-label">Number of UUIDs</label>
                        <input type="number" id="count" class="form-input" value="5" min="1" max="100">
                    </div>

                    <div class="form-group">
                        <label class="form-label">Version</label>
                        <select id="version" class="form-select">
                            <option value="v4">Version 4 (Random)</option>
                            <option value="v1">Version 1 (Timestamp)</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label class="checkbox-label">
                            <input type="checkbox" id="uppercase"> Uppercase
                        </label>
                    </div>

                    <div class="form-group">
                        <label class="checkbox-label">
                            <input type="checkbox" id="braces"> Add Braces {}
                        </label>
                    </div>

                    <div class="form-group">
                        <label class="checkbox-label">
                            <input type="checkbox" id="hyphens" checked> Hyphens
                        </label>
                    </div>

                    <button onclick="generateUUIDs()" class="btn btn-primary"
                        style="width: 100%; margin-top: var(--spacing-md);">
                        <i class="fas fa-rotate"></i> Generate UUIDs
                    </button>
                </div>

                <div>
                    <div class="flex justify-between items-center" style="margin-bottom: var(--spacing-sm);">
                        <label class="form-label">Generated UUIDs</label>
                        <button onclick="copyAllUUIDs()" class="btn btn-text btn-sm"><i class="fas fa-copy"></i> Copy
                            All</button>
                    </div>
                    <div id="uuidList" class="uuid-list">
                        <!-- UUIDs will be generated here -->
                    </div>
                </div>
            </div>
        </div>

        <div class="card" style="margin-top: var(--spacing-xl);">
            <h3>About UUIDs:</h3>
            <p>UUID (Universally Unique Identifier) is a 128-bit number used to identify information in computer systems.
                UUID v4 is randomly generated and is the most commonly used version.</p>
            <p style="margin-top: var(--spacing-md);"><strong>Format:</strong> xxxxxxxx-xxxx-4xxx-yxxx-xxxxxxxxxxxx</p>
            <p style="margin-top: var(--spacing-sm); font-size: 0.9rem; color: var(--text-secondary);">Click on any UUID to
                copy it individually.</p>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        let generatedUUIDs = [];

        function generateUUID() {
            return 'xxxxxxxx-xxxx-4xxx-yxxx-xxxxxxxxxxxx'.replace(/[xy]/g, function (c) {
                const r = Math.random() * 16 | 0;
                const v = c === 'x' ? r : (r & 0x3 | 0x8);
                return v.toString(16);
            });
        }

        function generateUUIDs() {
            const count = parseInt(document.getElementById('countInput').value);

            if (!count || count < 1 || count > 100) {
                showToast('Please enter a number between 1 and 100!', 'error');
                return;
            }

            generatedUUIDs = [];
            const container = document.getElementById('uuidContainer');
            container.innerHTML = '';

            for (let i = 0; i < count; i++) {
                const uuid = generateUUID();
                generatedUUIDs.push(uuid);

                const div = document.createElement('div');
                div.className = 'uuid-item';
                div.textContent = uuid;
                div.onclick = () => {
                    copyToClipboard(uuid);
                    showToast('UUID copied!');
                };
                container.appendChild(div);
            }

            document.getElementById('actionButtons').style.display = 'flex';
            showToast(`Generated ${count} UUID${count > 1 ? 's' : ''}!`);
        }

        function copyAllUUIDs() {
            const allUUIDs = generatedUUIDs.join('\n');
            copyToClipboard(allUUIDs);
            showToast(`Copied all ${generatedUUIDs.length} UUIDs!`);
        }

        // Generate initial set
        generateUUIDs();
    </script>
@endsection