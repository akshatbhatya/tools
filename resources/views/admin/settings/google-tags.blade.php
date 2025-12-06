@extends('admin.layout')

@section('title', 'Google Tags Settings')
@section('page-title', 'Google Tags Settings')

@section('content')
    <div class="content-card">
        <h2 style="margin-bottom: 10px; color: #333;">🏷️ Google Tags Configuration</h2>
        <p style="color: #666; margin-bottom: 30px;">Configure Google Analytics, Tag Manager, and Site Verification</p>

        <form action="{{ route('admin.settings.google-tags') }}" method="POST">
            @csrf

            <div class="form-group">
                <label for="google_analytics_id">
                    Google Analytics ID
                    <span style="color: #999; font-weight: normal; font-size: 12px;">(e.g., G-XXXXXXXXXX or
                        UA-XXXXXXXXX-X)</span>
                </label>
                <input type="text" id="google_analytics_id" name="google_analytics_id" class="form-control"
                    value="{{ $settings['google_analytics_id']->value ?? '' }}" placeholder="G-XXXXXXXXXX">
                <small style="color: #666; display: block; margin-top: 5px;">
                    Your Google Analytics Measurement ID or Tracking ID
                </small>
            </div>

            <div class="form-group">
                <label for="google_tag_manager_id">
                    Google Tag Manager ID
                    <span style="color: #999; font-weight: normal; font-size: 12px;">(e.g., GTM-XXXXXXX)</span>
                </label>
                <input type="text" id="google_tag_manager_id" name="google_tag_manager_id" class="form-control"
                    value="{{ $settings['google_tag_manager_id']->value ?? '' }}" placeholder="GTM-XXXXXXX">
                <small style="color: #666; display: block; margin-top: 5px;">
                    Your Google Tag Manager Container ID
                </small>
            </div>

            <div class="form-group">
                <label for="google_site_verification">
                    Google Site Verification Code
                    <span style="color: #999; font-weight: normal; font-size: 12px;">(Meta tag content value)</span>
                </label>
                <input type="text" id="google_site_verification" name="google_site_verification" class="form-control"
                    value="{{ $settings['google_site_verification']->value ?? '' }}"
                    placeholder="xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx">
                <small style="color: #666; display: block; margin-top: 5px;">
                    The content value from Google Search Console verification meta tag
                </small>
            </div>

            <div
                style="margin-top: 30px; padding: 20px; background: #e7f3ff; border-radius: 10px; border-left: 4px solid #2196F3;">
                <h4 style="color: #0d47a1; margin-bottom: 10px;">💡 How to Find These IDs</h4>
                <ul style="color: #0d47a1; line-height: 1.8; margin-left: 20px;">
                    <li><strong>Google Analytics:</strong> Go to Admin → Data Streams → Select your stream → Find
                        Measurement ID</li>
                    <li><strong>Tag Manager:</strong> Go to Admin → Container Settings → Find Container ID (GTM-XXXXXXX)
                    </li>
                    <li><strong>Site Verification:</strong> Google Search Console → Settings → Ownership verification → HTML
                        tag method</li>
                </ul>
            </div>

            <div style="margin-top: 30px; display: flex; gap: 15px;">
                <button type="submit" class="btn btn-primary">
                    💾 Save Settings
                </button>
                <a href="{{ route('admin.dashboard') }}"
                    style="padding: 12px 30px; background: #6c757d; color: white; text-decoration: none; border-radius: 8px; display: inline-block;">
                    Cancel
                </a>
            </div>
        </form>
    </div>
@endsection