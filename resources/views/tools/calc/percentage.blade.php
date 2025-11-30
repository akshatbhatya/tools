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

        .calc-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: var(--spacing-lg);
            margin-top: var(--spacing-xl);
        }

        .calc-card {
            background: var(--bg-glass);
            padding: var(--spacing-lg);
            border-radius: var(--radius-md);
            border: 2px solid var(--border-glass);
        }

        .calc-card h3 {
            margin-bottom: var(--spacing-md);
            color: var(--neon-primary);
        }

        .result-box {
            background: var(--gradient-primary);
            color: white;
            padding: var(--spacing-md);
            border-radius: var(--radius-md);
            text-align: center;
            margin-top: var(--spacing-md);
            font-size: 1.5rem;
            font-weight: bold;
        }
    </style>
@endsection

@section('content')
    <div class="tool-container">
        <div class="tool-header">
            <h1><i class="fas fa-percent"></i> {{ $title }}</h1>
            <p>{{ $description }}</p>
        </div>

        <div class="calc-grid">
            <!-- What is X% of Y -->
            <div class="calc-card card">
                <h3>What is X% of Y?</h3>
                <div class="form-group">
                    <input type="number" id="percent1" class="form-input" placeholder="Percentage" value="20">
                </div>
                <div class="form-group">
                    <input type="number" id="of1" class="form-input" placeholder="Number" value="100">
                </div>
                <button onclick="calculate1()" class="btn btn-primary" style="width: 100%;">Calculate</button>
                <div id="result1" class="result-box" style="display: none;"></div>
            </div>

            <!-- X is what % of Y -->
            <div class="calc-card card">
                <h3>X is what % of Y?</h3>
                <div class="form-group">
                    <input type="number" id="num2" class="form-input" placeholder="Number X" value="25">
                </div>
                <div class="form-group">
                    <input type="number" id="of2" class="form-input" placeholder="Number Y" value="100">
                </div>
                <button onclick="calculate2()" class="btn btn-primary" style="width: 100%;">Calculate</button>
                <div id="result2" class="result-box" style="display: none;"></div>
            </div>

            <!-- Percentage Increase -->
            <div class="calc-card card">
                <h3>Percentage Increase/Decrease</h3>
                <div class="form-group">
                    <input type="number" id="old" class="form-input" placeholder="Old Value" value="50">
                </div>
                <div class="form-group">
                    <input type="number" id="new" class="form-input" placeholder="New Value" value="75">
                </div>
                <button onclick="calculate3()" class="btn btn-primary" style="width: 100%;">Calculate</button>
                <div id="result3" class="result-box" style="display: none;"></div>
            </div>

            <!-- Percentage Difference -->
            <div class="calc-card card">
                <h3>Percentage Difference</h3>
                <div class="form-group">
                    <input type="number" id="value1" class="form-input" placeholder="Value 1" value="40">
                </div>
                <div class="form-group">
                    <input type="number" id="value2" class="form-input" placeholder="Value 2" value="60">
                </div>
                <button onclick="calculate4()" class="btn btn-primary" style="width: 100%;">Calculate</button>
                <div id="result4" class="result-box" style="display: none;"></div>
            </div>
        </div>

        <div class="card" style="margin-top: var(--spacing-xl);">
            <h3>Common Percentage Calculations:</h3>
            <ul style="padding-left: var(--spacing-lg); margin-top: var(--spacing-md);">
                <li><strong>What is X% of Y:</strong> Multiply Y by (X/100)</li>
                <li><strong>X is what % of Y:</strong> (X/Y) × 100</li>
                <li><strong>Percentage Change:</strong> ((New - Old) / Old) × 100</li>
                <li><strong>Percentage Difference:</strong> (|Value1 - Value2| / Average) × 100</li>
            </ul>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        function calculate1() {
            const percent = parseFloat(document.getElementById('percent1').value);
            const of = parseFloat(document.getElementById('of1').value);

            if (isNaN(percent) || isNaN(of)) {
                showToast('Please enter valid numbers', 'error');
                return;
            }

            const result = (percent / 100) * of;
            document.getElementById('result1').innerHTML = `${percent}% of ${of} = <strong>${result.toFixed(2)}</strong>`;
            document.getElementById('result1').style.display = 'block';
        }

        function calculate2() {
            const num = parseFloat(document.getElementById('num2').value);
            const of = parseFloat(document.getElementById('of2').value);

            if (isNaN(num) || isNaN(of) || of === 0) {
                showToast('Please enter valid numbers', 'error');
                return;
            }

            const result = (num / of) * 100;
            document.getElementById('result2').innerHTML = `${num} is <strong>${result.toFixed(2)}%</strong> of ${of}`;
            document.getElementById('result2').style.display = 'block';
        }

        function calculate3() {
            const oldVal = parseFloat(document.getElementById('old').value);
            const newVal = parseFloat(document.getElementById('new').value);

            if (isNaN(oldVal) || isNaN(newVal) || oldVal === 0) {
                showToast('Please enter valid numbers', 'error');
                return;
            }

            const change = ((newVal - oldVal) / oldVal) * 100;
            const type = change >= 0 ? 'Increase' : 'Decrease';
            document.getElementById('result3').innerHTML = `${type}: <strong>${Math.abs(change).toFixed(2)}%</strong>`;
            document.getElementById('result3').style.background = change >= 0 ? 'var(--gradient-accent)' : 'var(--gradient-warm)';
            document.getElementById('result3').style.display = 'block';
        }

        function calculate4() {
            const val1 = parseFloat(document.getElementById('value1').value);
            const val2 = parseFloat(document.getElementById('value2').value);

            if (isNaN(val1) || isNaN(val2)) {
                showToast('Please enter valid numbers', 'error');
                return;
            }

            const avg = (val1 + val2) / 2;
            const diff = Math.abs(val1 - val2);
            const result = (diff / avg) * 100;
            document.getElementById('result4').innerHTML = `Difference: <strong>${result.toFixed(2)}%</strong>`;
            document.getElementById('result4').style.display = 'block';
        }

        // Calculate on page load
        calculate1();
        calculate2();
        calculate3();
        calculate4();
    </script>
@endsection