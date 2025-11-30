@extends('layouts.app')

@section('title', $title)
@section('meta_description', $description)

@section('styles')
    <style>
        .tool-container {
            max-width: 700px;
            margin: var(--spacing-2xl) auto;
            padding: 0 var(--spacing-lg);
        }

        .gst-tabs {
            display: flex;
            gap: var(--spacing-sm);
            margin-bottom: var(--spacing-lg);
        }

        .gst-tab {
            flex: 1;
            padding: var(--spacing-md);
            background: var(--bg-glass);
            border: 2px solid var(--border-glass);
            border-radius: var(--radius-md);
            cursor: pointer;
            text-align: center;
            transition: all 0.3s ease;
        }

        .gst-tab.active {
            background: var(--gradient-primary);
            color: white;
            border-color: var(--neon-primary);
        }

        .result-grid {
            display: grid;
            gap: var(--spacing-md);
            margin-top: var(--spacing-lg);
        }

        .result-item {
            display: flex;
            justify-content: space-between;
            padding: var(--spacing-md);
            background: var(--bg-glass);
            border-radius: var(--radius-md);
            border-left: 4px solid var(--neon-primary);
        }

        .result-item strong {
            color: var(--neon-primary);
            font-size: 1.25rem;
        }
    </style>
@endsection

@section('content')
    <div class="tool-container">
        <div class="tool-header">
            <h1><i class="fas fa-file-invoice-dollar"></i> {{ $title }}</h1>
            <p>{{ $description }}</p>
        </div>

        <div class="card">
            <div class="gst-tabs">
                <div class="gst-tab active" onclick="switchTab('exclusive')">
                    <strong>GST Exclusive</strong>
                    <p style="font-size: 0.875rem; margin-top: 4px;">Add GST to Amount</p>
                </div>
                <div class="gst-tab" onclick="switchTab('inclusive')">
                    <strong>GST Inclusive</strong>
                    <p style="font-size: 0.875rem; margin-top: 4px;">Remove GST from Amount</p>
                </div>
            </div>

            <div class="form-group">
                <label class="form-label">Amount (₹)</label>
                <input type="number" id="amount" class="form-input" value="10000" min="0" step="0.01">
            </div>

            <div class="form-group">
                <label class="form-label">GST Rate (%)</label>
                <select id="gstRate" class="form-select">
                    <option value="0">0%</option>
                    <option value="0.25">0.25%</option>
                    <option value="3">3%</option>
                    <option value="5">5%</option>
                    <option value="12">12%</option>
                    <option value="18" selected>18%</option>
                    <option value="28">28%</option>
                </select>
            </div>

            <button onclick="calculateGST()" class="btn btn-primary" style="width: 100%;">
                <i class="fas fa-calculator"></i> Calculate GST
            </button>

            <div id="result" class="result-grid" style="display: none;">
                <div class="result-item">
                    <span>Original Amount:</span>
                    <strong>₹<span id="originalAmount">0</span></strong>
                </div>
                <div class="result-item">
                    <span>GST Amount:</span>
                    <strong>₹<span id="gstAmount">0</span></strong>
                </div>
                <div class="result-item" id="cgstRow">
                    <span>CGST (<span id="cgstRate">9</span>%):</span>
                    <strong>₹<span id="cgstAmount">0</span></strong>
                </div>
                <div class="result-item" id="sgstRow">
                    <span>SGST (<span id="sgstRate">9</span>%):</span>
                    <strong>₹<span id="sgstAmount">0</span></strong>
                </div>
                <div class="result-item"
                    style="border-left-color: var(--neon-accent); background: var(--gradient-primary); color: white;">
                    <span style="color: white;"><strong>Final Amount:</strong></span>
                    <strong style="color: white; font-size: 1.5rem;">₹<span id="finalAmount">0</span></strong>
                </div>
            </div>
        </div>

        <div class="card" style="margin-top: var(--spacing-xl);">
            <h3>GST Rates in India:</h3>
            <ul style="padding-left: var(--spacing-lg); margin-top: var(--spacing-md);">
                <li><strong>0%:</strong> Essential goods (bread, milk, fresh vegetables)</li>
                <li><strong>5%:</strong> Household necessities (sugar, tea, coffee)</li>
                <li><strong>12%:</strong> Standard goods (computers, processed food)</li>
                <li><strong>18%:</strong> Most services and products</li>
                <li><strong>28%:</strong> Luxury items (cars, tobacco)</li>
            </ul>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        let currentTab = 'exclusive';

        function switchTab(tab) {
            currentTab = tab;
            document.querySelectorAll('.gst-tab').forEach(t => t.classList.remove('active'));
            event.target.closest('.gst-tab').classList.add('active');
            calculateGST();
        }

        function calculateGST() {
            const amount = parseFloat(document.getElementById('amount').value);
            const gstRate = parseFloat(document.getElementById('gstRate').value);

            if (!amount || amount <= 0) {
                return;
            }

            let originalAmount, gstAmount, finalAmount;

            if (currentTab === 'exclusive') {
                // GST Exclusive: Add GST to amount
                originalAmount = amount;
                gstAmount = (amount * gstRate) / 100;
                finalAmount = amount + gstAmount;
            } else {
                // GST Inclusive: Remove GST from amount
                finalAmount = amount;
                originalAmount = amount / (1 + gstRate / 100);
                gstAmount = amount - originalAmount;
            }

            const cgst = gstAmount / 2;
            const sgst = gstAmount / 2;
            const halfRate = gstRate / 2;

            // Display results
            document.getElementById('originalAmount').textContent = originalAmount.toFixed(2);
            document.getElementById('gstAmount').textContent = gstAmount.toFixed(2);
            document.getElementById('cgstAmount').textContent = cgst.toFixed(2);
            document.getElementById('sgstAmount').textContent = sgst.toFixed(2);
            document.getElementById('cgstRate').textContent = halfRate;
            document.getElementById('sgstRate').textContent = halfRate;
            document.getElementById('finalAmount').textContent = finalAmount.toFixed(2);

            document.getElementById('result').style.display = 'grid';
        }

        // Calculate on page load
        calculateGST();
    </script>
@endsection