@extends('admin.layout')

@section('title', 'Google Ads Settings')
@section('page-title', 'Google Ads Settings')

@section('content')
<div class="content-card">
    <h2 style="margin-bottom: 10px; color: #333;">📢 Google Ads Configuration</h2>
    <p style="color: #666; margin-bottom: 30px;">Configure Google AdSense for your website</p>

    <form action="{{ route('admin.settings.google-ads') }}" method="POST">
        @csrf

        <div class="form-group">
            <div class="checkbox-group">
                <input 
                    type="checkbox" 
                    id="google_ads_enabled" 
                    name="google_ads_enabled" 
                    value="1"
                    {{ ($settings['google_ads_enabled']->value ?? false) ? 'checked' : '' }}
                >
                <label for="google_ads_enabled">Enable Google Ads</label>
            </div>
            <small style="color: #666; display: block; margin-top: 5px;">
                Toggle to enable or disable Google Ads across the entire website
            </small>
        </div>

        <div class="form-group">
            <label for="google_ads_client">
                Google AdSense Client ID
                <span style="color: #999; font-weight: normal; font-size: 12px;">(e.g., ca-pub-XXXXXXXXXXXXXXXX)</span>
            </label>
            <input 
                type="text" 
                id="google_ads_client" 
                name="google_ads_client" 
                class="form-control"
                value="{{ $settings['google_ads_client']->value ?? '' }}"
                placeholder="ca-pub-XXXXXXXXXXXXXXXX"
            >
            <small style="color: #666; display: block; margin-top: 5px;">
                Your Google AdSense Publisher ID
            </small>
        </div>

        <hr style="margin: 30px 0; border: none; border-top: 2px solid #f0f0f0;">

        <h3 style="color: #333; margin-bottom: 20px;">Ad Slot IDs</h3>
        <p style="color: #666; margin-bottom: 20px; font-size: 14px;">
            Configure different ad slots for various positions on your website
        </p>

        <div class="form-group">
            <label for="google_ads_slot_header">
                Header Ad Slot ID
                <span style="color: #999; font-weight: normal; font-size: 12px;">(Displayed at the top of pages)</span>
            </label>
            <input 
                type="text" 
                id="google_ads_slot_header" 
                name="google_ads_slot_header" 
                class="form-control"
                value="{{ $settings['google_ads_slot_header']->value ?? '' }}"
                placeholder="1234567890"
            >
        </div>

        <div class="form-group">
            <label for="google_ads_slot_sidebar">
                Sidebar Ad Slot ID
                <span style="color: #999; font-weight: normal; font-size: 12px;">(Displayed in sidebar areas)</span>
            </label>
            <input 
                type="text" 
                id="google_ads_slot_sidebar" 
                name="google_ads_slot_sidebar" 
                class="form-control"
                value="{{ $settings['google_ads_slot_sidebar']->value ?? '' }}"
                placeholder="1234567890"
            >
        </div>

        <div class="form-group">
            <label for="google_ads_slot_footer">
                Footer Ad Slot ID
                <span style="color: #999; font-weight: normal; font-size: 12px;">(Displayed at the bottom of pages)</span>
            </label>
            <input 
                type="text" 
                id="google_ads_slot_footer" 
                name="google_ads_slot_footer" 
                class="form-control"
                value="{{ $settings['google_ads_slot_footer']->value ?? '' }}"
                placeholder="1234567890"
            >
        </div>

        <div style="margin-top: 30px; padding: 20px; background: #fff3cd; border-radius: 10px; border-left: 4px solid #ffc107;">
            <h4 style="color: #856404; margin-bottom: 10px;">💡 How to Find Your AdSense IDs</h4>
            <ul style="color: #856404; line-height: 1.8; margin-left: 20px;">
                <li><strong>Client ID:</strong> Go to AdSense → Account → Account Information → Publisher ID</li>
                <li><strong>Ad Slot IDs:</strong> Go to AdSense → Ads → Ad units → Select an ad unit → Copy the data-ad-slot value</li>
                <li>Each ad unit has a unique slot ID that identifies where the ad should appear</li>
            </ul>
        </div>

        <div style="margin-top: 30px; display: flex; gap: 15px;">
            <button type="submit" class="btn btn-primary">
                💾 Save Settings
            </button>
            <a href="{{ route('admin.dashboard') }}" style="padding: 12px 30px; background: #6c757d; color: white; text-decoration: none; border-radius: 8px; display: inline-block;">
                Cancel
            </a>
        </div>
    </form>
</div>
@endsection
