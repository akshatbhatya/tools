<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TextToolsController extends Controller
{
    public function wordCounter()
    {
        return view('tools.text.word-counter', [
            'title' => 'Word Counter - Count Words & Characters',
            'description' => 'Count words, characters, sentences, and paragraphs in real-time.'
        ]);
    }

    public function caseConverter()
    {
        return view('tools.text.case-converter', [
            'title' => 'Case Converter - Change Text Case',
            'description' => 'Convert text to UPPERCASE, lowercase, Title Case, and more.'
        ]);
    }

    public function spaceRemover()
    {
        return view('tools.text.space-remover', [
            'title' => 'Remove Extra Spaces',
            'description' => 'Remove extra spaces and line breaks from your text.'
        ]);
    }

    public function notepad()
    {
        return view('tools.text.notepad', [
            'title' => 'Online Notepad',
            'description' => 'Quick notepad with auto-save to your browser.'
        ]);
    }
}
