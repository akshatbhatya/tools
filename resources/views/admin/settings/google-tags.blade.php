@extends('admin.layout')

@section('title', 'Google Tags Settings')
@section('page-title', 'Google Tags Settings')

@section('content')
    <div class="content-card">
        <h2 style="margin-bottom: var(--spacing-sm);"><i class="fas fa-tags" style="color: var(--neon-primary);"></i> Google
            Tags Configuration</h2>
        <p style="color: var(--text-muted); margin-bottom: var(--spacing-xl);">Configure Google Analytics, Tag Manager, and
            Site Verification</p>

        <form action="{{ route('admin.settings.google-tags') }}" method="POST">
            @csrf

            <div class="form-group">
                <label for="google_analytics_id">
                    Google Analytics ID
                    <span style="color: var(--text-muted); font-weight: normal; font-size: 0.75rem;">(e.g., G-XXXXXXXXXX or
                        UA-XXXXXXXXX-X)</span>
                </label>
                <input type="text" id="google_analytics_id" name="google_analytics_id" class="form-control"
                    value="{{ $settings['google_analytics_id']->value ?? '' }}" placeholder="G-XXXXXXXXXX">
                <small style="color: var(--text-muted); display: block; margin-top: var(--spacing-xs);">
                    Your Google Analytics Measurement ID or Tracking ID
                </small>
            </div>

            <div class="form-group">
                <label for="google_tag_manager_id">
                    Google Tag Manager ID
                    <span style="color: var(--text-muted); font-weight: normal; font-size: 0.75rem;">(e.g.,
                        GTM-XXXXXXX)</span>
                </label>
                <input type="text" id="google_tag_manager_id" name="google_tag_manager_id" class="form-control"
                    value="{{ $settings['google_tag_manager_id']->value ?? '' }}" placeholder="GTM-XXXXXXX">
                <small style="color: var(--text-muted); display: block; margin-top: var(--spacing-xs);">
                    Your Google Tag Manager Container ID
                </small>
            </div>

            <div class="form-group">
                <label for="google_site_verification">
                    Google Site Verification Code
                    <span style="color: var(--text-muted); font-weight: normal; font-size: 0.75rem;">(Meta tag content
                        value)</span>
                </label>
                <input type="text" id="google_site_verification" name="google_site_verification" class="form-control"
                    value="{{ $settings['google_site_verification']->value ?? '' }}"
                    placeholder="xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx">
                <small style="color: var(--text-muted); display: block; margin-top: var(--spacing-xs);">
                    The content value from Google Search Console verification meta tag
                </small>
            </div>

            <div
                style="margin-top: var(--spacing-xl); padding: var(--spacing-lg); background: rgba(0, 242, 255, 0.1); border-radius: var(--radius-md); border-left: 4px solid var(--neon-primary);">
                <h4 style="color: var(--neon-primary); margin-bottom: var(--spacing-sm);"><i class="fas fa-lightbulb"></i>
                    How to Find These IDs</h4>
                <ul style="color: var(--text-muted); line-height: 1.8; margin-left: 20px;">
                    <li><strong>Google Analytics:</strong> Go to Admin → Data Streams → Select your stream → Find
                        Measurement ID</li>
                    <li><strong>Tag Manager:</strong> Go to Admin → Container Settings → Find Container ID (GTM-XXXXXXX)
                    </li>
                    <li><strong>Site Verification:</strong> Google Search Console → Settings → Ownership verification → HTML
                        tag method</li>
                </ul>
            </div>

            <div style="margin-top: var(--spacing-xl); display: flex; gap: var(--spacing-md);">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> Save Settings
                </button>
                <a href="{{ route('admin.dashboard') }}" class="btn"
                    style="background: rgba(255, 255, 255, 0.1); color: var(--text-main); border: 1px solid rgba(255, 255, 255, 0.2);">
                    Cancel
                </a>
            </div>
        </form>
    </div>
@endsection