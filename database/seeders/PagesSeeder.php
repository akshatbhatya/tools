<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PagesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $pages = [
            // Home
            [
                'route_name' => 'home',
                'title' => 'Web Tools Hub - Free Online Tools',
                'meta_title' => 'Web Tools Hub - Free Online Tools for PDF, Image, Text & SEO',
                'meta_description' => 'Free online tools for PDF, images, text, SEO, and more. Boost your productivity with our collection of web tools.',
                'meta_keywords' => 'online tools, pdf tools, image tools, text tools, seo tools, calculators',
            ],
            // PDF Tools
            [
                'route_name' => 'pdf.merge',
                'title' => 'Merge PDF Files',
                'meta_title' => 'Merge PDF Files Online - Free PDF Combiner',
                'meta_description' => 'Combine multiple PDF files into one document quickly and easily. Free online PDF merger tool.',
                'meta_keywords' => 'merge pdf, combine pdf, join pdf, pdf merger',
            ],
            [
                'route_name' => 'pdf.split',
                'title' => 'Split PDF Files',
                'meta_title' => 'Split PDF Files Online - Extract PDF Pages',
                'meta_description' => 'Split PDF files into multiple documents or extract specific pages. Free online PDF splitter.',
                'meta_keywords' => 'split pdf, extract pdf pages, separate pdf',
            ],
            [
                'route_name' => 'pdf.compress',
                'title' => 'Compress PDF',
                'meta_title' => 'Compress PDF Online - Reduce PDF File Size',
                'meta_description' => 'Reduce PDF file size without losing quality. Optimize PDF documents for web and email.',
                'meta_keywords' => 'compress pdf, reduce pdf size, optimize pdf',
            ],
            [
                'route_name' => 'pdf.to.word',
                'title' => 'PDF to Word',
                'meta_title' => 'PDF to Word Converter - Convert PDF to Docx',
                'meta_description' => 'Convert PDF documents to editable Word files (Docx) online for free.',
                'meta_keywords' => 'pdf to word, convert pdf to docx, pdf converter',
            ],
            [
                'route_name' => 'word.to.pdf',
                'title' => 'Word to PDF',
                'meta_title' => 'Word to PDF Converter - Convert Docx to PDF',
                'meta_description' => 'Convert Microsoft Word documents to PDF format online for free.',
                'meta_keywords' => 'word to pdf, docx to pdf, convert word to pdf',
            ],
            [
                'route_name' => 'images.to.pdf',
                'title' => 'Images to PDF',
                'meta_title' => 'Images to PDF Converter - JPG/PNG to PDF',
                'meta_description' => 'Convert images (JPG, PNG, WebP) to a single PDF file online.',
                'meta_keywords' => 'images to pdf, jpg to pdf, png to pdf',
            ],
            // Text Tools
            [
                'route_name' => 'text.word.counter',
                'title' => 'Word Counter',
                'meta_title' => 'Word Counter - Count Words, Characters & Lines',
                'meta_description' => 'Free online word counter tool. Count words, characters, sentences, and paragraphs in your text.',
                'meta_keywords' => 'word counter, character count, word count tool',
            ],
            [
                'route_name' => 'text.case.converter',
                'title' => 'Case Converter',
                'meta_title' => 'Case Converter - Upper, Lower, Title Case',
                'meta_description' => 'Convert text case online: uppercase, lowercase, title case, sentence case, and more.',
                'meta_keywords' => 'case converter, uppercase, lowercase, title case',
            ],
            [
                'route_name' => 'text.space.remover',
                'title' => 'Space Remover',
                'meta_title' => 'Remove Extra Spaces - Clean Up Text',
                'meta_description' => 'Remove extra spaces, tabs, and line breaks from your text online.',
                'meta_keywords' => 'remove spaces, trim text, clean text',
            ],
            [
                'route_name' => 'text.notepad',
                'title' => 'Online Notepad',
                'meta_title' => 'Online Notepad - Free Text Editor',
                'meta_description' => 'Simple online notepad for writing and editing text. Auto-saves your work locally.',
                'meta_keywords' => 'online notepad, text editor, online notes',
            ],
            // Image Tools
            [
                'route_name' => 'image.compressor',
                'title' => 'Image Compressor',
                'meta_title' => 'Image Compressor - Optimize Images Online',
                'meta_description' => 'Compress JPG, PNG, and WebP images online without losing quality. Reduce image file size for free.',
                'meta_keywords' => 'image compressor, compress jpg, compress png, optimize image',
            ],
            [
                'route_name' => 'image.resizer',
                'title' => 'Image Resizer',
                'meta_title' => 'Image Resizer - Resize Images Online',
                'meta_description' => 'Resize images to specific dimensions or percentage online. Free image resizing tool.',
                'meta_keywords' => 'image resizer, resize image, change image size',
            ],
            [
                'route_name' => 'image.converter',
                'title' => 'Image Converter',
                'meta_title' => 'Image Converter - Convert Image Formats',
                'meta_description' => 'Convert images between JPG, PNG, WebP, and other formats online.',
                'meta_keywords' => 'image converter, convert image format, jpg to png',
            ],
            [
                'route_name' => 'image.cropper',
                'title' => 'Image Cropper',
                'meta_title' => 'Image Cropper - Crop Images Online',
                'meta_description' => 'Crop images to exact dimensions or aspect ratios online for free.',
                'meta_keywords' => 'image cropper, crop image, cut image',
            ],
            [
                'route_name' => 'image.enhancer',
                'title' => 'Image Enhancer',
                'meta_title' => 'Image Enhancer - Improve Image Quality',
                'meta_description' => 'Enhance image quality, adjust brightness, contrast, and saturation online.',
                'meta_keywords' => 'image enhancer, improve photo quality, photo editor',
            ],
            // SEO Tools
            [
                'route_name' => 'seo.meta.generator',
                'title' => 'Meta Tag Generator',
                'meta_title' => 'Meta Tag Generator - Create SEO Meta Tags',
                'meta_description' => 'Generate SEO-friendly meta tags for your website. Improve your search engine ranking with proper meta tags.',
                'meta_keywords' => 'meta tag generator, seo meta tags, meta description generator',
            ],
            [
                'route_name' => 'seo.robots.generator',
                'title' => 'Robots.txt Generator',
                'meta_title' => 'Robots.txt Generator - Create Robots.txt',
                'meta_description' => 'Generate a robots.txt file for your website to control search engine crawling.',
                'meta_keywords' => 'robots.txt generator, create robots.txt, seo tools',
            ],
            [
                'route_name' => 'seo.serp.preview',
                'title' => 'SERP Preview',
                'meta_title' => 'Google SERP Preview Tool',
                'meta_description' => 'Preview how your website will appear in Google search results.',
                'meta_keywords' => 'serp preview, google search preview, seo snippet preview',
            ],
            [
                'route_name' => 'seo.index.checker',
                'title' => 'Google Index Checker',
                'meta_title' => 'Google Index Checker - Check URL Index Status',
                'meta_description' => 'Check if a URL is indexed by Google. Bulk index checker tool.',
                'meta_keywords' => 'google index checker, check google index, is my site indexed',
            ],
            // Developer Tools
            [
                'route_name' => 'dev.json.formatter',
                'title' => 'JSON Formatter',
                'meta_title' => 'JSON Formatter & Validator - Beautify JSON',
                'meta_description' => 'Format and validate JSON data online. Beautify minified JSON code for better readability.',
                'meta_keywords' => 'json formatter, json validator, beautify json',
            ],
            [
                'route_name' => 'dev.html.formatter',
                'title' => 'HTML Formatter',
                'meta_title' => 'HTML Formatter - Beautify HTML Code',
                'meta_description' => 'Format and beautify HTML code online. Indent nested tags for better readability.',
                'meta_keywords' => 'html formatter, beautify html, format html code',
            ],
            [
                'route_name' => 'dev.css.minifier',
                'title' => 'CSS Minifier',
                'meta_title' => 'CSS Minifier - Minify CSS Code',
                'meta_description' => 'Minify CSS code to reduce file size and improve page load speed.',
                'meta_keywords' => 'css minifier, minify css, compress css',
            ],
            [
                'route_name' => 'dev.js.minifier',
                'title' => 'JS Minifier',
                'meta_title' => 'JS Minifier - Minify JavaScript Code',
                'meta_description' => 'Minify JavaScript code to reduce file size and improve performance.',
                'meta_keywords' => 'js minifier, minify javascript, compress js',
            ],
            [
                'route_name' => 'dev.uuid.generator',
                'title' => 'UUID Generator',
                'meta_title' => 'UUID Generator - Generate Unique IDs',
                'meta_description' => 'Generate random UUIDs (Universally Unique Identifiers) version 4 online.',
                'meta_keywords' => 'uuid generator, generate uuid, guid generator',
            ],
            [
                'route_name' => 'dev.lorem.ipsum',
                'title' => 'Lorem Ipsum Generator',
                'meta_title' => 'Lorem Ipsum Generator - Dummy Text',
                'meta_description' => 'Generate Lorem Ipsum placeholder text for your designs and mockups.',
                'meta_keywords' => 'lorem ipsum generator, dummy text, placeholder text',
            ],
            // Calculators
            [
                'route_name' => 'calc.bmi',
                'title' => 'BMI Calculator',
                'meta_title' => 'BMI Calculator - Calculate Body Mass Index',
                'meta_description' => 'Calculate your Body Mass Index (BMI) based on height and weight.',
                'meta_keywords' => 'bmi calculator, body mass index, health calculator',
            ],
            [
                'route_name' => 'calc.age',
                'title' => 'Age Calculator',
                'meta_title' => 'Age Calculator - Calculate Your Age',
                'meta_description' => 'Calculate your exact age in years, months, and days from your date of birth.',
                'meta_keywords' => 'age calculator, calculate age, date of birth calculator',
            ],
            [
                'route_name' => 'calc.loan',
                'title' => 'Loan Calculator',
                'meta_title' => 'Loan Calculator - Calculate EMI',
                'meta_description' => 'Calculate monthly loan payments (EMI) based on principal, interest rate, and tenure.',
                'meta_keywords' => 'loan calculator, emi calculator, mortgage calculator',
            ],
            [
                'route_name' => 'calc.gst',
                'title' => 'GST Calculator',
                'meta_title' => 'GST Calculator - Calculate GST Amount',
                'meta_description' => 'Calculate Goods and Services Tax (GST) inclusive and exclusive amounts.',
                'meta_keywords' => 'gst calculator, calculate gst, tax calculator',
            ],
            [
                'route_name' => 'calc.percentage',
                'title' => 'Percentage Calculator',
                'meta_title' => 'Percentage Calculator - Calculate Percentages',
                'meta_description' => 'Calculate percentages, percentage increase/decrease, and more.',
                'meta_keywords' => 'percentage calculator, calculate percentage, math tool',
            ],
            [
                'route_name' => 'calc.date',
                'title' => 'Date Calculator',
                'meta_title' => 'Date Calculator - Days Between Dates',
                'meta_description' => 'Calculate the number of days, weeks, and months between two dates.',
                'meta_keywords' => 'date calculator, days between dates, time duration',
            ],
        ];

        foreach ($pages as $page) {
            \App\Models\Page::updateOrCreate(
                ['route_name' => $page['route_name']],
                $page
            );
        }
    }
}
