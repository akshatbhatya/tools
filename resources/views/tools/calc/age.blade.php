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

        .result-card {
            background: var(--gradient-primary);
            color: white;
            padding: var(--spacing-xl);
            border-radius: var(--radius-md);
            text-align: center;
            margin: var(--spacing-xl) 0;
            display: none;
        }

        .result-card h2 {
            color: white;
            font-size: 2.5rem;
            margin-bottom: var(--spacing-sm);
        }

        .age-details {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
            gap: var(--spacing-md);
            margin-top: var(--spacing-md);
        }

        .age-detail-item {
            background: rgba(255, 255, 255, 0.2);
            padding: var(--spacing-md);
            border-radius: var(--radius-md);
        }

        .age-detail-item strong {
            display: block;
            font-size: 1.5rem;
            margin-bottom: var(--spacing-xs);
        }
    </style>
@endsection

@section('content')
    <div class="tool-container">
        <div class="tool-header">
            <h1><i class="fas fa-birthday-cake"></i> {{ $title }}</h1>
            <p>{{ $description }}</p>
        </div>

        <div class="card">
            <div class="form-group">
                <label class="form-label">Date of Birth</label>
                <input type="date" id="birthDate" class="form-input" value="1990-01-01">
            </div>

            <div class="form-group">
                <label class="form-label">Calculate Age as of</label>
                <input type="date" id="targetDate" class="form-input">
            </div>

            <button onclick="calculateAge()" class="btn btn-primary" style="width: 100%;">
                <i class="fas fa-calculator"></i> Calculate Age
            </button>

            <div id="result" class="result-card">
                <h2 id="ageYears">0</h2>
                <p>Years Old</p>

                <div class="age-details">
                    <div class="age-detail-item">
                        <strong id="ageMonths">0</strong>
                        <span>Months</span>
                    </div>
                    <div class="age-detail-item">
                        <strong id="ageDays">0</strong>
                        <span>Days</span>
                    </div>
                    <div class="age-detail-item">
                        <strong id="ageWeeks">0</strong>
                        <span>Weeks</span>
                    </div>
                    <div class="age-detail-item">
                        <strong id="totalDays">0</strong>
                        <span>Total Days</span>
                    </div>
                </div>

                <p style="margin-top: var(--spacing-md); font-size: 0.9rem; opacity: 0.9;" id="nextBirthday">
                    Next birthday in: <strong id="daysToNext">0</strong> days
                </p>
            </div>
        </div>

        <div class="card" style="margin-top: var(--spacing-xl);">
            <h3>How It Works:</h3>
            <p>The age calculator computes your exact age by calculating the difference between your date of birth and the
                target date. It provides detailed information including years, months, weeks, days, and total days lived.
            </p>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        // Set today's date as default
        document.getElementById('targetDate').valueAsDate = new Date();

        function calculateAge() {
            const birthDate = new Date(document.getElementById('birthDate').value);
            const targetDate = new Date(document.getElementById('targetDate').value);

            if (!birthDate || !targetDate) {
                showToast('Please select both dates!', 'error');
                return;
            }

            if (birthDate > targetDate) {
                showToast('Birth date cannot be after target date!', 'error');
                return;
            }

            // Calculate age
            let years = targetDate.getFullYear() - birthDate.getFullYear();
            let months = targetDate.getMonth() - birthDate.getMonth();
            let days = targetDate.getDate() - birthDate.getDate();

            if (days < 0) {
                months--;
                const prevMonth = new Date(targetDate.getFullYear(), targetDate.getMonth(), 0);
                days += prevMonth.getDate();
            }

            if (months < 0) {
                years--;
                months += 12;
            }

            // Calculate total days
            const timeDiff = targetDate.getTime() - birthDate.getTime();
            const totalDays = Math.floor(timeDiff / (1000 * 3600 * 24));
            const weeks = Math.floor(totalDays / 7);

            // Calculate days to next birthday
            let nextBirthday = new Date(targetDate.getFullYear(), birthDate.getMonth(), birthDate.getDate());
            if (nextBirthday < targetDate) {
                nextBirthday.setFullYear(targetDate.getFullYear() + 1);
            }
            const daysToNext = Math.ceil((nextBirthday - targetDate) / (1000 * 3600 * 24));

            // Display results
            document.getElementById('ageYears').textContent = years;
            document.getElementById('ageMonths').textContent = months;
            document.getElementById('ageDays').textContent = days;
            document.getElementById('ageWeeks').textContent = weeks.toLocaleString();
            document.getElementById('totalDays').textContent = totalDays.toLocaleString();
            document.getElementById('daysToNext').textContent = daysToNext;

            document.getElementById('result').style.display = 'block';
            document.getElementById('result').scrollIntoView({ behavior: 'smooth', block: 'nearest' });
        }

        // Allow Enter key to calculate
        document.getElementById('birthDate').addEventListener('change', calculateAge);
        document.getElementById('targetDate').addEventListener('change', calculateAge);
    </script>
@endsection