@extends('admin.layout')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard')

@section('content')
    <div class="content-card">
        <h2 style="margin-bottom: 30px; color: #333;">Welcome to Admin Dashboard</h2>

        <div
            style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 20px; margin-bottom: 30px;">
            <!-- Stats Cards -->
            <div
                style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); padding: 30px; border-radius: 15px; color: white; box-shadow: 0 5px 15px rgba(102, 126, 234, 0.3);">
                <div style="font-size: 40px; margin-bottom: 10px;">⚙️</div>
                <h3 style="font-size: 32px; margin-bottom: 5px;">{{ $stats['total_settings'] }}</h3>
                <p style="opacity: 0.9;">Total Settings</p>
            </div>

            <div
                style="background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%); padding: 30px; border-radius: 15px; color: white; box-shadow: 0 5px 15px rgba(240, 147, 251, 0.3);">
                <div style="font-size: 40px; margin-bottom: 10px;">🏷️</div>
                <h3 style="font-size: 32px; margin-bottom: 5px;">{{ $stats['google_tags'] }}</h3>
                <p style="opacity: 0.9;">Google Tags</p>
            </div>

            <div
                style="background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%); padding: 30px; border-radius: 15px; color: white; box-shadow: 0 5px 15px rgba(79, 172, 254, 0.3);">
                <div style="font-size: 40px; margin-bottom: 10px;">📢</div>
                <h3 style="font-size: 32px; margin-bottom: 5px;">{{ $stats['google_ads'] }}</h3>
                <p style="opacity: 0.9;">Google Ads</p>
            </div>
        </div>

        <div style="background: #f8f9fa; padding: 25px; border-radius: 10px; border-left: 4px solid #667eea;">
            <h3 style="color: #333; margin-bottom: 15px;">Quick Actions</h3>
            <div style="display: flex; gap: 15px; flex-wrap: wrap;">
                <a href="{{ route('admin.settings.google-tags') }}"
                    style="display: inline-block; padding: 12px 24px; background: #667eea; color: white; text-decoration: none; border-radius: 8px; transition: transform 0.2s;">
                    Manage Google Tags
                </a>
                <a href="{{ route('admin.settings.google-ads') }}"
                    style="display: inline-block; padding: 12px 24px; background: #f5576c; color: white; text-decoration: none; border-radius: 8px; transition: transform 0.2s;">
                    Manage Google Ads
                </a>
                <a href="{{ route('home') }}" target="_blank"
                    style="display: inline-block; padding: 12px 24px; background: #4facfe; color: white; text-decoration: none; border-radius: 8px; transition: transform 0.2s;">
                    View Website
                </a>
            </div>
        </div>

        <div
            style="margin-top: 30px; padding: 20px; background: #fff3cd; border-radius: 10px; border-left: 4px solid #ffc107;">
            <h4 style="color: #856404; margin-bottom: 10px;">ℹ️ Information</h4>
            <p style="color: #856404; line-height: 1.6;">
                Use this admin panel to manage Google Analytics, Google Tag Manager, Google Ads, and other site-wide
                settings.
                Changes made here will be reflected immediately on the frontend.
            </p>
        </div>
    </div>
@endsection