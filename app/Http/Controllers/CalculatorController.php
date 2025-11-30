<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CalculatorController extends Controller
{
    public function bmi()
    {
        return view('tools.calc.bmi', [
            'title' => 'BMI Calculator - Body Mass Index',
            'description' => 'Calculate your Body Mass Index and get health insights.'
        ]);
    }

    public function age()
    {
        return view('tools.calc.age', [
            'title' => 'Age Calculator',
            'description' => 'Calculate age in years, months, and days.'
        ]);
    }

    public function loan()
    {
        return view('tools.calc.loan', [
            'title' => 'Loan Calculator - EMI Calculator',
            'description' => 'Calculate monthly EMI and loan details.'
        ]);
    }

    public function gst()
    {
        return view('tools.calc.gst', [
            'title' => 'GST Calculator',
            'description' => 'Calculate GST inclusive and exclusive amounts.'
        ]);
    }

    public function percentage()
    {
        return view('tools.calc.percentage', [
            'title' => 'Percentage Calculator',
            'description' => 'Calculate percentages, increase, decrease, and more.'
        ]);
    }

    public function date()
    {
        return view('tools.calc.date', [
            'title' => 'Date Calculator - Date Difference',
            'description' => 'Calculate difference between two dates.'
        ]);
    }
}
