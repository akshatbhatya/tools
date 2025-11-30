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
            margin: var(--spacing-xl) 0;
            display: none;
        }

        .date-details {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
            gap: var(--spacing-md);
            margin-top: var(--spacing-md);
        }

        .date-detail-item {
            background: rgba(255, 255, 255, 0.2);
            padding: var(--spacing-md);
            border-radius: var(--radius-md);
            text-align: center;
        }

        .date-detail-item strong {
            display: block;
            font-size: 1.75rem;
            margin-bottom: var(--spacing-xs);
        }
    </style>
@endsection

@section('content')
    <div class="tool-container">
        <div class="tool-header">
            <h1><i class="fas fa-calendar-alt"></i> {{ $title }}</h1>
            <p>{{ $description }}</p>
        </div>

        <div class="card">
            <div class="form-group">
                <label class="form-label">From Date</label>
                <input type="date" id="fromDate" class="form-input" value="2024-01-01">
            </div>

            <div class="form-group">
                <label class="form-label">To Date</label>
                <input type="date" id="toDate" class="form-input">
            </div>

            <button onclick="calculateDateDiff()" class="btn btn-primary" style="width: 100%;">
                <i class="fas fa-calculator"></i> Calculate Difference
            </button>

            <div id="result" class="result-card">
                <h2 style="color: white; text-align: center; margin-bottom: var(--spacing-lg);">Time Difference</h2>

                <div class="date-details">
                    <div class="date-detail-item">
                        <strong id="years">0</strong>
                        <span>Years</span>
                    </div>
                    <div class="date-detail-item">
                        <strong id="months">0</strong>
                        <span>Months</span>
                    </div>
                    <div class="date-detail-item">
                        <strong id="days">0</strong>
                        <span>Days</span>
                    </div>
                </div>

                <div
                    style="margin-top: var(--spacing-lg); padding-top: var(--spacing-lg); border-top: 1px solid rgba(255,255,255,0.2);">
                    <h3 style="color: white; margin-bottom: var(--spacing-md);">Alternative Calculations:</h3>
                    <div class="date-details">
                        <div class="date-detail-item">
                            <strong id="totalDays">0</strong>
                            <span>Total Days</span>
                        </div>
                        <div class="date-detail-item">
                            <strong id="totalWeeks">0</strong>
                            <span>Total Weeks</span>
                        </div>
                        <div class="date-detail-item">
                            <strong id="totalMonths">0</strong>
                            <span>Total Months</span>
                        </div>
                        <div class="date-detail-item">
                            <strong id="totalHours">0</strong>
                            <span>Total Hours</span>
                        </div>
                        <div class="date-detail-item">
                            <strong id="totalMinutes">0</strong>
                            <span>Total Minutes</span>
                        </div>
                        <div class="date-detail-item">
                            <strong id="totalSeconds">0</strong>
                            <span>Total Seconds</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card" style="margin-top: var(--spacing-xl);">
            <h3>How It Works:</h3>
            <p>The date calculator computes the exact difference between two dates. It provides detailed information
                including years, months, days, and alternative calculations in weeks, hours, minutes, and seconds.</p>
            <p style="margin-top: var(--spacing-md);"><strong>Note:</strong> All calculations are based on the Gregorian
                calendar.</p>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        // Set today's date as default
        document.getElementById('toDate').valueAsDate = new Date();

        function calculateDateDiff() {
            const fromDate = new Date(document.getElementById('fromDate').value);
            const toDate = new Date(document.getElementById('toDate').value);

            if (!fromDate || !toDate) {
                showToast('Please select both dates!', 'error');
                return;
            }

            // Ensure from date is before to date
            let startDate = fromDate < toDate ? fromDate : toDate;
            let endDate = fromDate < toDate ? toDate : fromDate;

            // Calculate difference in years, months, days
            let years = endDate.getFullYear() - startDate.getFullYear();
            let months = endDate.getMonth() - startDate.getMonth();
            let days = endDate.getDate() - startDate.getDate();

            if (days < 0) {
                months--;
                const prevMonth = new Date(endDate.getFullYear(), endDate.getMonth(), 0);
                days += prevMonth.getDate();
            }

            if (months < 0) {
                years--;
                months += 12;
            }

            // Calculate totals
            const timeDiff = Math.abs(endDate.getTime() - startDate.getTime());
            const totalDays = Math.floor(timeDiff / (1000 * 3600 * 24));
            const totalWeeks = Math.floor(totalDays / 7);
            const totalMonths = years * 12 + months;
            const totalHours = Math.floor(timeDiff / (1000 * 3600));
            const totalMinutes = Math.floor(timeDiff / (1000 * 60));
            const totalSeconds = Math.floor(timeDiff / 1000);

            // Display results
            document.getElementById('years').textContent = years;
            document.getElementById('months').textContent = months;
            document.getElementById('days').textContent = days;
            document.getElementById('totalDays').textContent = totalDays.toLocaleString();
            document.getElementById('totalWeeks').textContent = totalWeeks.toLocaleString();
            document.getElementById('totalMonths').textContent = totalMonths.toLocaleString();
            document.getElementById('totalHours').textContent = totalHours.toLocaleString();
            document.getElementById('totalMinutes').textContent = totalMinutes.toLocaleString();
            document.getElementById('totalSeconds').textContent = totalSeconds.toLocaleString();

            document.getElementById('result').style.display = 'block';
            document.getElementById('result').scrollIntoView({ behavior: 'smooth', block: 'nearest' });
        }

        // Allow auto-calculation on date change
        document.getElementById('fromDate').addEventListener('change', calculateDateDiff);
        document.getElementById('toDate').addEventListener('change', calculateDateDiff);
    </script>
@endsection