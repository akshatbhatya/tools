<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PdfToolsController;
use App\Http\Controllers\TextToolsController;
use App\Http\Controllers\ImageToolsController;
use App\Http\Controllers\SeoToolsController;
use App\Http\Controllers\DeveloperToolsController;
use App\Http\Controllers\CalculatorController;
use App\Http\Controllers\PageController;

// Homepage
Route::get('/', [HomeController::class, 'index'])->name('home');

// Login redirect (for compatibility)
Route::get('/login', function () {
    return redirect()->route('admin.login');
})->name('login');

// PDF Tools
Route::prefix('tools/pdf')->group(function () {
    Route::get('/merge', [PdfToolsController::class, 'merge'])->name('pdf.merge');
    Route::post('/merge', [PdfToolsController::class, 'processMerge']);

    Route::get('/split', [PdfToolsController::class, 'split'])->name('pdf.split');
    Route::post('/split', [PdfToolsController::class, 'processSplit']);

    Route::get('/compress', [PdfToolsController::class, 'compress'])->name('pdf.compress');
    Route::post('/compress', [PdfToolsController::class, 'processCompress']);

    Route::get('/pdf-to-word', [PdfToolsController::class, 'pdfToWord'])->name('pdf.to.word');
    Route::post('/pdf-to-word', [PdfToolsController::class, 'processPdfToWord']);

    Route::get('/word-to-pdf', [PdfToolsController::class, 'wordToPdf'])->name('word.to.pdf');
    Route::post('/word-to-pdf', [PdfToolsController::class, 'processWordToPdf']);

    Route::get('/images-to-pdf', [PdfToolsController::class, 'imagesToPdf'])->name('images.to.pdf');
    Route::post('/images-to-pdf', [PdfToolsController::class, 'processImagesToPdf']);
});

// Text Tools
Route::prefix('tools/text')->group(function () {
    Route::get('/word-counter', [TextToolsController::class, 'wordCounter'])->name('text.word.counter');
    Route::get('/case-converter', [TextToolsController::class, 'caseConverter'])->name('text.case.converter');
    Route::get('/space-remover', [TextToolsController::class, 'spaceRemover'])->name('text.space.remover');
    Route::get('/notepad', [TextToolsController::class, 'notepad'])->name('text.notepad');
});

// Image Tools
Route::prefix('tools/image')->group(function () {
    Route::get('/compressor', [ImageToolsController::class, 'compressor'])->name('image.compressor');
    Route::post('/compress', [ImageToolsController::class, 'processCompress']);

    Route::get('/resizer', [ImageToolsController::class, 'resizer'])->name('image.resizer');
    Route::post('/resize', [ImageToolsController::class, 'processResize']);

    Route::get('/converter', [ImageToolsController::class, 'converter'])->name('image.converter');
    Route::post('/convert', [ImageToolsController::class, 'processConvert']);

    Route::get('/cropper', [ImageToolsController::class, 'cropper'])->name('image.cropper');

    Route::get('/enhancer', [ImageToolsController::class, 'enhancer'])->name('image.enhancer');
});

// SEO Tools
Route::prefix('tools/seo')->group(function () {
    Route::get('/meta-generator', [SeoToolsController::class, 'metaGenerator'])->name('seo.meta.generator');
    Route::get('/robots-generator', [SeoToolsController::class, 'robotsGenerator'])->name('seo.robots.generator');
    Route::get('/serp-preview', [SeoToolsController::class, 'serpPreview'])->name('seo.serp.preview');
    Route::get('/index-checker', [SeoToolsController::class, 'indexChecker'])->name('seo.index.checker');
    Route::post('/check-index', [SeoToolsController::class, 'checkIndex']);
});

// Developer Tools
Route::prefix('tools/dev')->group(function () {
    Route::get('/json-formatter', [DeveloperToolsController::class, 'jsonFormatter'])->name('dev.json.formatter');
    Route::get('/html-formatter', [DeveloperToolsController::class, 'htmlFormatter'])->name('dev.html.formatter');
    Route::get('/css-minifier', [DeveloperToolsController::class, 'cssMinifier'])->name('dev.css.minifier');
    Route::get('/js-minifier', [DeveloperToolsController::class, 'jsMinifier'])->name('dev.js.minifier');
    Route::get('/uuid-generator', [DeveloperToolsController::class, 'uuidGenerator'])->name('dev.uuid.generator');
    Route::get('/lorem-ipsum', [DeveloperToolsController::class, 'loremIpsum'])->name('dev.lorem.ipsum');
});

// Calculators
Route::prefix('tools/calc')->group(function () {
    Route::get('/bmi', [CalculatorController::class, 'bmi'])->name('calc.bmi');
    Route::get('/age', [CalculatorController::class, 'age'])->name('calc.age');
    Route::get('/loan', [CalculatorController::class, 'loan'])->name('calc.loan');
    Route::get('/gst', [CalculatorController::class, 'gst'])->name('calc.gst');
    Route::get('/percentage', [CalculatorController::class, 'percentage'])->name('calc.percentage');
    Route::get('/date', [CalculatorController::class, 'date'])->name('calc.date');
});

// Static Pages
Route::get('/about', [PageController::class, 'about'])->name('about');
Route::get('/privacy', [PageController::class, 'privacy'])->name('privacy');
Route::get('/terms', [PageController::class, 'terms'])->name('terms');
Route::get('/contact', [PageController::class, 'contact'])->name('contact');
Route::post('/contact', [PageController::class, 'submitContact'])->name('contact.submit');

// Admin Routes
require __DIR__ . '/admin.php';
