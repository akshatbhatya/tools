@extends('layouts.app')

@section('title', $title)
@section('meta_description', $description)

@section('content')
    <div style="max-width: 1100px; margin: var(--spacing-2xl) auto; padding: 0 var(--spacing-lg);">
        <div class="tool-header">
            <h1><i class="fas fa-brackets-curly"></i> {{ $title }}</h1>
            <p>{{ $description }}</p>
        </div>

        <div class="card">
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: var(--spacing-lg);">
                <div>
                    <div
                        style="display: flex; justify-content: space-between; align-items: center; margin-bottom: var(--spacing-sm);">
                        <h3>JSON Input</h3>
                        <div style="display: flex; gap: var(--spacing-sm);">
                            <button onclick="loadSample()" class="btn btn-text btn-sm">Load Sample</button>
                            <button onclick="clearAll()" class="btn btn-text btn-sm"
                                style="color: var(--neon-accent);">Clear</button>
                        </div>
                    </div>
                    <textarea id="jsonInput" class="form-input"
                        style="min-height: 400px; font-family: 'Courier New', monospace; font-size: 0.875rem;" placeholder='Paste your JSON here...
    Example:
    {"name":"John","age":30,"city":"New York"}'></textarea>
                </div>

                <div>
                    <div
                        style="display: flex; justify-content: space-between; align-items: center; margin-bottom: var(--spacing-sm);">
                        <h3>Result</h3>
                        <button onclick="copyResult()" class="btn btn-text btn-sm">
                            <i class="fas fa-copy"></i> Copy
                        </button>
                    </div>
                    <textarea id="jsonOutput" class="form-input"
                        style="min-height: 400px; font-family: 'Courier New', monospace; font-size: 0.875rem;" readonly
                        placeholder="Result will appear here..."></textarea>
                </div>
            </div>

            <div style="display: flex; gap: var(--spacing-md); margin-top: var(--spacing-md);">
                <button onclick="formatJSON()" class="btn btn-primary" style="flex: 1;">
                    <i class="fas fa-indent"></i> Format / Beautify
                </button>
                <button onclick="minifyJSON()" class="btn btn-outline" style="flex: 1;">
                    <i class="fas fa-compress"></i> Minify
                </button>
                <button onclick="validateJSON()" class="btn btn-outline" style="flex: 1;">
                    <i class="fas fa-check"></i> Validate
                </button>
            </div>

            <div id="statusMessage"
                style="display: none; margin-top: var(--spacing-md); padding: var(--spacing-md); border-radius: var(--radius-md);">
            </div>
        </div>

        <div class="card" style="margin-top: var(--spacing-xl);">
            <h3>About JSON Formatter:</h3>
            <p style="margin-top: var(--spacing-md);">This tool helps you format, validate, and minify JSON data. Perfect
                for debugging API responses or cleaning up JSON files.</p>
            <ul style="padding-left: var(--spacing-lg); margin-top: var(--spacing-md);">
                <li><strong>Format:</strong> Beautifies JSON with proper indentation (2 spaces)</li>
                <li><strong>Minify:</strong> Removes all whitespace to reduce file size</li>
                <li><strong>Validate:</strong> Checks if your JSON is valid and shows errors</li>
            </ul>
        </div>
    </div>

    <script>
        function formatJSON() {
            const input = document.getElementById('jsonInput').value.trim();
            const output = document.getElementById('jsonOutput');
            const message = document.getElementById('statusMessage');

            if (!input) {
                showMessage('Please enter some JSON', 'error');
                return;
            }

            try {
                const parsed = JSON.parse(input);
                output.value = JSON.stringify(parsed, null, 2);
                showMessage('✅ Valid JSON - Formatted!', 'success');
                showToast('JSON formatted successfully!');
            } catch (error) {
                showMessage(`❌ Invalid JSON: ${error.message}`, 'error');
                output.value = '';
                showToast('Invalid JSON: ' + error.message, 'error');
            }
        }

        function minifyJSON() {
            const input = document.getElementById('jsonInput').value.trim();
            const output = document.getElementById('jsonOutput');
            const message = document.getElementById('statusMessage');

            if (!input) {
                showMessage('Please enter some JSON', 'error');
                return;
            }

            try {
                const parsed = JSON.parse(input);
                output.value = JSON.stringify(parsed);
                const savings = ((1 - output.value.length / input.length) * 100).toFixed(1);
                showMessage(`✅ JSON Minified! Saved ${savings}%`, 'success');
                showToast(`JSON minified! Saved ${savings}%`);
            } catch (error) {
                showMessage(`❌ Invalid JSON: ${error.message}`, 'error');
                output.value = '';
                showToast('Invalid JSON: ' + error.message, 'error');
            }
        }

        function validateJSON() {
            const input = document.getElementById('jsonInput').value.trim();
            const message = document.getElementById('statusMessage');

            if (!input) {
                showMessage('Please enter some JSON', 'error');
                return;
            }

            try {
                const parsed = JSON.parse(input);
                const keys = Object.keys(parsed).length;
                showMessage(`✅ Valid JSON! Contains ${keys} top-level ${keys === 1 ? 'key' : 'keys'}`, 'success');
                showToast('JSON is valid!');
            } catch (error) {
                showMessage(`❌ Invalid JSON: ${error.message}`, 'error');
                showToast('Invalid JSON: ' + error.message, 'error');
            }
        }

        function copyResult() {
            const output = document.getElementById('jsonOutput');
            if (!output.value) {
                showToast('Nothing to copy!', 'error');
                return;
            }
            copyToClipboard(output.value);
        }

        function clearAll() {
            document.getElementById('jsonInput').value = '';
            document.getElementById('jsonOutput').value = '';
            document.getElementById('statusMessage').style.display = 'none';
        }

        function loadSample() {
            const sample = {
                "name": "John Doe",
                "age": 30,
                "email": "john@example.com",
                "address": {
                    "street": "123 Main St",
                    "city": "New York",
                    "country": "USA"
                },
                "hobbies": ["reading", "coding", "gaming"],
                "active": true
            };
            document.getElementById('jsonInput').value = JSON.stringify(sample);
            formatJSON();
        }

        function showMessage(text, type) {
            const message = document.getElementById('statusMessage');
            message.textContent = text;
            message.style.display = 'block';
            message.style.background = type === 'success' ? 'var(--gradient-accent)' : 'var(--gradient-warm)';
            message.style.color = 'white';
            message.style.fontWeight = 'bold';

            setTimeout(() => {
                message.style.display = 'none';
            }, 3000);
        }

        // Load sample on page load
        loadSample();
    </script>
@endsection