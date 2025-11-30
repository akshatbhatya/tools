<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;

class DeveloperToolsController extends Controller
{
    public function jsonFormatter()
    {
        return view('tools.dev.json-formatter', [
            'title' => 'JSON Formatter & Validator',
            'description' => 'Format, validate, and beautify JSON data.'
        ]);
    }

    public function htmlFormatter()
    {
        return view('tools.dev.html-formatter', [
            'title' => 'HTML Formatter - Beautify HTML',
            'description' => 'Format and beautify HTML code.'
        ]);
    }

    public function cssMinifier()
    {
        return view('tools.dev.css-minifier', [
            'title' => 'CSS Minifier - Compress CSS',
            'description' => 'Minify CSS code to reduce file size.'
        ]);
    }

    public function jsMinifier()
    {
        return view('tools.dev.js-minifier', [
            'title' => 'JavaScript Minifier',
            'description' => 'Minify JavaScript code for production.'
        ]);
    }

    public function uuidGenerator()
    {
        return view('tools.dev.uuid-generator', [
            'title' => 'UUID Generator - Generate UUIDs',
            'description' => 'Generate unique identifiers (UUID v4).'
        ]);
    }

    public function loremIpsum()
    {
        return view('tools.dev.lorem-ipsum', [
            'title' => 'Lorem Ipsum Generator',
            'description' => 'Generate placeholder text for your projects.'
        ]);
    }
}
