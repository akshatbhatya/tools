@extends('layouts.app')

@section('title', 'Page Not Found - ToolsHub')

@section('content')
    <div class="container"
        style="min-height: 70vh; display: flex; align-items: center; justify-content: center; text-align: center; margin-top: 80px;">
        <div class="content-card" style="padding: var(--spacing-xl); max-width: 600px;">
            <div
                style="font-size: 8rem; font-weight: 800; background: var(--gradient-primary); -webkit-background-clip: text; -webkit-text-fill-color: transparent; line-height: 1;">
                404
            </div>
            <h2 style="margin-bottom: var(--spacing-md); font-size: 2rem;">Page Not Found</h2>
            <p style="color: var(--text-muted); margin-bottom: var(--spacing-xl); font-size: 1.1rem;">
                Oops! The page you are looking for might have been removed, had its name changed, or is temporarily
                unavailable.
            </p>

            <a href="{{ url('/') }}" class="btn btn-primary" style="padding: 12px 30px; font-size: 1.1rem;">
                <i class="fas fa-home"></i> Go to Homepage
            </a>
        </div>
    </div>
@endsection