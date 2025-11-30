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

        .result-card {
            background: var(--gradient-primary);
            color: white;
            padding: var(--spacing-xl);
            border-radius: var(--radius-md);
            margin: var(--spacing-xl) 0;
            display: none;
        }

        .emi-breakdown {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: var(--spacing-md);
            margin-top: var(--spacing-md);
        }

        .emi-item {
            background: rgba(255, 255, 255, 0.2);
            padding: var(--spacing-md);
            border-radius: var(--radius-md);
            text-align: center;
        }

        .emi-item h3 {
            color: white;
            font-size: 1.75rem;
            margin-bottom: var(--spacing-xs);
        }
    </style>
@endsection

@section('content')
    <div class="tool-container">
        <div class="tool-header">
            <h1><i class="fas fa-money-bill-wave"></i> {{ $title }}</h1>
            <p>{{ $description }}</p>
        </div>

        <div class="card">
            <div class="form-group">
                <label class="form-label">Loan Amount (₹)</label>
                <input type="number" id="loanAmount" class="form-input" value="1000000" min="1000" step="1000">
            </div>

            <div class="form-group">
                <label class="form-label">Interest Rate (% per annum)</label>
                <input type="number" id="interestRate" class="form-input" value="8.5" min="0.1" max="50" step="0.1">
            </div>

            <div class="form-group">
                <label class="form-label">Loan Tenure (years)</label>
                <input type="number" id="tenure" class="form-input" value="20" min="1" max="30">
            </div>

            <button onclick="calculateEMI()" class="btn btn-primary" style="width: 100%;">
                <i class="fas fa-calculator"></i> Calculate EMI
            </button>

            <div id="result" class="result-card">
                <h2 style="color: white; margin-bottom: var(--spacing-lg);">Monthly EMI</h2>
                <h1 style="color: white; font-size: 3rem; margin-bottom: var(--spacing-xl);">₹<span id="emiAmount">0</span>
                </h1>

                <div class="emi-breakdown">
                    <div class="emi-item">
                        <h3>₹<span id="totalAmount">0</span></h3>
                        <p>Total Amount Payable</p>
                    </div>
                    <div class="emi-item">
                        <h3>₹<span id="totalInterest">0</span></h3>
                        <p>Total Interest</p>
                    </div>
                    <div class="emi-item">
                        <h3><span id="totalMonths">0</span></h3>
                        <p>Total Months</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="card" style="margin-top: var(--spacing-xl);">
            <h3>EMI Formula:</h3>
            <p>EMI = [P x R x (1+R)^N] / [(1+R)^N-1]</p>
            <ul style="margin-top: var(--spacing-md); padding-left: var(--spacing-lg);">
                <li>P = Principal loan amount</li>
                <li>R = Monthly interest rate (Annual rate / 12 / 100)</li>
                <li>N = Number of monthly installments</li>
            </ul>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        function calculateEMI() {
            const principal = parseFloat(document.getElementById('loanAmount').value);
            const annualRate = parseFloat(document.getElementById('interestRate').value);
            const years = parseFloat(document.getElementById('tenure').value);

            if (!principal || !annualRate || !years || principal <= 0 || annualRate <= 0 || years <= 0) {
                showToast('Please enter valid values!', 'error');
                return;
            }

            // Calculate monthly interest rate
            const monthlyRate = annualRate / 12 / 100;
            const months = years * 12;

            // EMI = [P x R x (1+R)^N] / [(1+R)^N-1]
            const emi = (principal * monthlyRate * Math.pow(1 + monthlyRate, months)) /
                (Math.pow(1 + monthlyRate, months) - 1);

            const totalAmount = emi * months;
            const totalInterest = totalAmount - principal;

            // Display results
            document.getElementById('emiAmount').textContent = Math.round(emi).toLocaleString('en-IN');
            document.getElementById('totalAmount').textContent = Math.round(totalAmount).toLocaleString('en-IN');
            document.getElementById('totalInterest').textContent = Math.round(totalInterest).toLocaleString('en-IN');
            document.getElementById('totalMonths').textContent = months;

            document.getElementById('result').style.display = 'block';
            document.getElementById('result').scrollIntoView({ behavior: 'smooth', block: 'nearest' });
        }
    </script>
@endsection