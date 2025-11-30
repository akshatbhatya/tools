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

        .tool-header {
            text-align: center;
            margin-bottom: var(--spacing-2xl);
        }

        .input-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: var(--spacing-md);
            margin-bottom: var(--spacing-md);
        }

        @media (max-width: 600px) {
            .input-row {
                grid-template-columns: 1fr;
            }
        }

        .result-card {
            background: var(--gradient-primary);
            color: white;
            padding: var(--spacing-xl);
            border-radius: var(--radius-xl);
            text-align: center;
            margin: var(--spacing-xl) 0;
        }

        .result-card h2 {
            color: white;
            font-size: 3rem;
            margin-bottom: var(--spacing-sm);
        }

        .category {
            background: rgba(255, 255, 255, 0.2);
            padding: var(--spacing-md);
            border-radius: var(--radius-md);
            margin-top: var(--spacing-md);
        }
    </style>
@endsection

@section('content')
    <div class="tool-container">
        <div class="tool-header">
            <h1><i class="fas fa-weight-scale"></i> {{ $title }}</h1>
            <p>{{ $description }}</p>
        </div>

        <div class="card">
            <div class="grid grid-cols-2 gap-xl">
                <div>
                    <div class="form-group">
                        <label class="form-label">Gender</label>
                        <div class="flex gap-md">
                            <label class="radio-label">
                                <input type="radio" name="gender" value="male" checked> Male
                            </label>
                            <label class="radio-label">
                                <input type="radio" name="gender" value="female"> Female
                            </label>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Age</label>
                        <input type="number" id="age" class="form-input" value="25" min="2" max="120">
                    </div>

                    <div class="form-group">
                        <label class="form-label">Height (cm)</label>
                        <input type="number" id="height" class="form-input" value="170" min="50" max="300">
                    </div>

                    <div class="form-group">
                        <label class="form-label">Weight (kg)</label>
                        <input type="number" id="weight" class="form-input" value="70" min="10" max="300">
                    </div>

                    <button onclick="calculateBMI()" class="btn btn-primary"
                        style="width: 100%; margin-top: var(--spacing-md);">
                        <i class="fas fa-calculator"></i> Calculate BMI
                    </button>
                </div>

                <div class="result-section" id="resultSection" style="display: none;">
                    <h3 style="margin-bottom: var(--spacing-lg);">Your Result</h3>

                    <div class="bmi-value" id="bmiValue">0.0</div>
                    <div class="bmi-category" id="bmiCategory">-</div>

                    <div class="bmi-scale">
                        <div class="scale-bar">
                            <div class="scale-marker" id="scaleMarker"></div>
                        </div>
                        <div class="scale-labels">
                            <span>Underweight</span>
                            <span>Normal</span>
                            <span>Overweight</span>
                            <span>Obese</span>
                        </div>
                    </div>

                    <div class="health-tip" id="healthTip">
                        <i class="fas fa-info-circle"></i> <span>Calculate your BMI to see health tips.</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="card" style="margin-top: var(--spacing-xl);">
            <h3>BMI Categories:</h3>
            <ul style="list-style: none; padding: 0; margin-top: var(--spacing-md);">
                <li
                    style="padding: var(--spacing-sm); margin-bottom: var(--spacing-sm); background: var(--gray-100); border-radius: var(--radius-md);">
                    <strong>Underweight:</strong> BMI less than 18.5
                </li>
                <li
                    style="padding: var(--spacing-sm); margin-bottom: var(--spacing-sm); background: var(--gray-100); border-radius: var(--radius-md);">
                    <strong>Normal weight:</strong> BMI 18.5-24.9
                </li>
                <li
                    style="padding: var(--spacing-sm); margin-bottom: var(--spacing-sm); background: var(--gray-100); border-radius: var(--radius-md);">
                    <strong>Overweight:</strong> BMI 25-29.9
                </li>
                <li style="padding: var(--spacing-sm); background: var(--gray-100); border-radius: var(--radius-md);">
                    <strong>Obese:</strong> BMI 30 or higher
                </li>
            </ul>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        function calculateBMI() {
            const weight = parseFloat(document.getElementById('weightInput').value);
            const height = parseFloat(document.getElementById('heightInput').value);

            if (!weight || !height || weight <= 0 || height <= 0) {
                showToast('Please enter valid weight and height!', 'error');
                return;
            }

            // BMI = weight (kg) / (height (m))^2
            const heightInMeters = height / 100;
            const bmi = weight / (heightInMeters * heightInMeters);

            let category, description, gradient;

            if (bmi < 18.5) {
                category = 'Underweight';
                description = 'Consider consulting a nutritionist to achieve a healthy weight.';
                gradient = 'var(--gradient-cool)';
            } else if (bmi < 25) {
                category = 'Normal Weight';
                description = 'Great! You have a healthy weight. Keep it up!';
                gradient = 'var(--gradient-accent)';
            } else if (bmi < 30) {
                category = 'Overweight';
                description = 'Consider regular exercise and a balanced diet.';
                gradient = 'var(--gradient-warm)';
            } else {
                category = 'Obese';
                description = 'Consider consulting a healthcare provider for guidance.';
                gradient = 'var(--gradient-secondary)';
            }

            document.getElementById('bmiValue').textContent = bmi.toFixed(1);
            document.getElementById('categoryText').textContent = category;
            document.getElementById('categoryDescription').textContent = description;

            const resultCard = document.getElementById('result');
            resultCard.style.background = gradient;
            resultCard.style.display = 'block';

            resultCard.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
        }

        // Allow Enter key to calculate
        document.getElementById('weightInput').addEventListener('keypress', function (e) {
            if (e.key === 'Enter') calculateBMI();
        });
        document.getElementById('heightInput').addEventListener('keypress', function (e) {
            if (e.key === 'Enter') calculateBMI();
        });
    </script>
@endsection