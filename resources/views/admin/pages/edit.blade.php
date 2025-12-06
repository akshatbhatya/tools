@extends('admin.layout')

@section('title', 'Edit SEO Settings')
@section('page-title', 'Edit SEO Settings')

@section('content')
    <div class="content-card">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: var(--spacing-lg);">
            <div>
                <h2 style="margin-bottom: var(--spacing-xs);"><i class="fas fa-edit"
                        style="color: var(--neon-primary);"></i> Edit Page SEO</h2>
                <p style="color: var(--text-muted);">Editing SEO settings for route: <span
                        style="color: var(--neon-primary);">{{ $page->route_name }}</span></p>
            </div>
            <a href="{{ route('admin.pages.index') }}" class="btn"
                style="background: rgba(255, 255, 255, 0.1); color: var(--text-main); border: 1px solid rgba(255, 255, 255, 0.2); padding: 8px 16px; border-radius: 6px; text-decoration: none;">
                <i class="fas fa-arrow-left"></i> Back to List
            </a>
        </div>

        <form action="{{ route('admin.pages.update', $page->id) }}" method="POST">
            @csrf

            <div class="form-group">
                <label for="title">Page Title (H1)</label>
                <input type="text" id="title" name="title" class="form-control" value="{{ old('title', $page->title) }}">
                <small style="color: var(--text-muted); display: block; margin-top: var(--spacing-xs);">
                    The main heading of the page (H1 tag).
                </small>
            </div>

            <div class="form-group">
                <label for="meta_title">Meta Title (SEO)</label>
                <input type="text" id="meta_title" name="meta_title" class="form-control"
                    value="{{ old('meta_title', $page->meta_title) }}">
                <small style="color: var(--text-muted); display: block; margin-top: var(--spacing-xs);">
                    The title tag shown in search engine results (approx. 60 characters).
                </small>
            </div>

            <div class="form-group">
                <label for="meta_description">Meta Description</label>
                <textarea id="meta_description" name="meta_description" class="form-control"
                    rows="3">{{ old('meta_description', $page->meta_description) }}</textarea>
                <small style="color: var(--text-muted); display: block; margin-top: var(--spacing-xs);">
                    The description shown in search engine results (approx. 160 characters).
                </small>
            </div>

            <div class="form-group">
                <label for="meta_keywords">Meta Keywords</label>
                <input type="text" id="meta_keywords" name="meta_keywords" class="form-control"
                    value="{{ old('meta_keywords', $page->meta_keywords) }}">
                <small style="color: var(--text-muted); display: block; margin-top: var(--spacing-xs);">
                    Comma-separated keywords (e.g., pdf tools, online converter).
                </small>
            </div>

            <div class="form-group">
                <label for="canonical_url">Canonical URL</label>
                <input type="url" id="canonical_url" name="canonical_url" class="form-control"
                    value="{{ old('canonical_url', $page->canonical_url) }}">
                <small style="color: var(--text-muted); display: block; margin-top: var(--spacing-xs);">
                    The preferred URL for this page to prevent duplicate content issues.
                </small>
            </div>

            <div class="form-group">
                <label for="og_image">Open Graph Image URL</label>
                <input type="url" id="og_image" name="og_image" class="form-control"
                    value="{{ old('og_image', $page->og_image) }}">
                <small style="color: var(--text-muted); display: block; margin-top: var(--spacing-xs);">
                    URL of the image to display when shared on social media (1200x630px recommended).
                </small>
            </div>

            <div class="form-group">
                <label for="schema_markup">Schema Markup (JSON-LD)</label>
                <textarea id="schema_markup" name="schema_markup" class="form-control" rows="10"
                    style="font-family: monospace; font-size: 0.9rem;">{{ old('schema_markup', $page->schema_markup) }}</textarea>
                <small style="color: var(--text-muted); display: block; margin-top: var(--spacing-xs);">
                    Add custom JSON-LD schema markup here. It will be injected into the head of the page.
                </small>
            </div>

            <div style="margin-top: var(--spacing-xl); display: flex; gap: var(--spacing-md);">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> Save Changes
                </button>
                <a href="{{ route('admin.pages.index') }}" class="btn"
                    style="background: rgba(255, 255, 255, 0.1); color: var(--text-main); border: 1px solid rgba(255, 255, 255, 0.2); padding: 10px 20px; border-radius: 6px; text-decoration: none;">
                    Cancel
                </a>
            </div>
        </form>
    </div>
@endsection