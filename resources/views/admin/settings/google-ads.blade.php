@extends('admin.layout')

@section('title', 'Google Ads Settings')
@section('page-title', 'Google Ads Settings')

@section('content')
<div class="content-card">
    <h2 style="margin-bottom: var(--spacing-sm);"><i class="fas fa-bullhorn" style="color: var(--neon-primary);"></i> Google Ads Configuration</h2>
    <p style="color: var(--text-muted); margin-bottom: var(--spacing-xl);">Configure Google AdSense for your website</p>

    <form action="{{ route('admin.settings.google-ads') }}" method="POST">
        @csrf

        <div class="form-group">
            <div class="checkbox-group" style="display: flex; align-items: center; gap: var(--spacing-sm);">
                <input 
                    type="checkbox" 
                    id="google_ads_enabled" 
                    name="google_ads_enabled" 
                    value="1"
                    style="width: 20px; height: 20px; accent-color: var(--neon-primary);"
                    {{ ($settings['google_ads_enabled']->value ?? false) ? 'checked' : '' }}
                >
                <label for="google_ads_enabled" style="margin-bottom: 0; cursor: pointer; color: var(--text-main);">Enable Google Ads</label>
            </div>
            <small style="color: var(--text-muted); display: block; margin-top: var(--spacing-xs); margin-left: 28px;">
                Toggle to enable or disable Google Ads across the entire website
            </small>
        </div>

        <div class="form-group">
            <label for="google_ads_client">
                Google AdSense Client ID
                <span style="color: var(--text-muted); font-weight: normal; font-size: 0.75rem;">(e.g., ca-pub-XXXXXXXXXXXXXXXX)</span>
            </label>
            <input 
                type="text" 
                id="google_ads_client" 
                name="google_ads_client" 
                class="form-control"
                value="{{ $settings['google_ads_client']->value ?? '' }}"
                placeholder="ca-pub-XXXXXXXXXXXXXXXX"
            >
            <small style="color: var(--text-muted); display: block; margin-top: var(--spacing-xs);">
                Your Google AdSense Publisher ID
            </small>
        </div>

        <hr style="margin: var(--spacing-xl) 0; border: none; border-top: 1px solid rgba(255, 255, 255, 0.1);">

        <h3 style="color: var(--text-main); margin-bottom: var(--spacing-md);">Ad Slot IDs</h3>
        <p style="color: var(--text-muted); margin-bottom: var(--spacing-lg); font-size: 0.875rem;">
            Configure different ad slots for various positions on your website
        </p>

        <div class="form-group">
            <label for="google_ads_slot_header">
                Header Ad Slot ID
                <span style="color: var(--text-muted); font-weight: normal; font-size: 0.75rem;">(Displayed at the top of pages)</span>
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
                <span style="color: var(--text-muted); font-weight: normal; font-size: 0.75rem;">(Displayed in sidebar areas)</span>
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
                <span style="color: var(--text-muted); font-weight: normal; font-size: 0.75rem;">(Displayed at the bottom of pages)</span>
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

        <div style="margin-top: var(--spacing-xl); padding: var(--spacing-lg); background: rgba(255, 149, 0, 0.1); border-radius: var(--radius-md); border-left: 4px solid var(--neon-warn);">
            <h4 style="color: var(--neon-warn); margin-bottom: var(--spacing-sm);"><i class="fas fa-lightbulb"></i> How to Find Your AdSense IDs</h4>
            <ul style="color: var(--text-muted); line-height: 1.8; margin-left: 20px;">
                <li><strong>Client ID:</strong> Go to AdSense → Account → Account Information → Publisher ID</li>
                <li><strong>Ad Slot IDs:</strong> Go to AdSense → Ads → Ad units → Select an ad unit → Copy the data-ad-slot value</li>
                <li>Each ad unit has a unique slot ID that identifies where the ad should appear</li>
            </ul>
        </div>

        <div style="margin-top: var(--spacing-xl); display: flex; gap: var(--spacing-md);">
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-save"></i> Save Settings
            </button>
            <a href="{{ route('admin.dashboard') }}" class="btn" style="background: rgba(255, 255, 255, 0.1); color: var(--text-main); border: 1px solid rgba(255, 255, 255, 0.2);">
                Cancel
            </a>
        </div>
    </form>
</div>
@endsection
