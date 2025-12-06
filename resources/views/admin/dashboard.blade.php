@extends('admin.layout')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard')

@section('content')
    <div class="content-card">
        <h2 style="margin-bottom: var(--spacing-lg);">Welcome to Admin Dashboard</h2>

        <div class="grid grid-cols-3" style="margin-bottom: var(--spacing-xl);">
            <!-- Stats Cards -->
            <div class="card">
                <div class="card-icon" style="background: var(--gradient-primary);">
                    <i class="fas fa-cog"></i>
                </div>
                <h3 class="card-title" style="font-size: 2.5rem; margin-top: var(--spacing-sm);">
                    {{ $stats['total_settings'] }}</h3>
                <p class="card-description">Total Settings</p>
            </div>

            <div class="card">
                <div class="card-icon" style="background: var(--gradient-accent);">
                    <i class="fas fa-tags"></i>
                </div>
                <h3 class="card-title" style="font-size: 2.5rem; margin-top: var(--spacing-sm);">{{ $stats['google_tags'] }}
                </h3>
                <p class="card-description">Google Tags</p>
            </div>

            <div class="card">
                <div class="card-icon" style="background: var(--gradient-cool);">
                    <i class="fas fa-bullhorn"></i>
                </div>
                <h3 class="card-title" style="font-size: 2.5rem; margin-top: var(--spacing-sm);">{{ $stats['google_ads'] }}
                </h3>
                <p class="card-description">Google Ads</p>
            </div>
        </div>

        <div class="grid grid-cols-2">
            <div class="card">
                <h3 class="card-title" style="margin-bottom: var(--spacing-md);"><i class="fas fa-bolt"
                        style="color: var(--neon-warn);"></i> Quick Actions</h3>
                <div style="display: flex; gap: var(--spacing-md); flex-wrap: wrap;">
                    <a href="{{ route('admin.settings.google-tags') }}" class="btn btn-primary">
                        <i class="fas fa-tags"></i> Manage Tags
                    </a>
                    <a href="{{ route('admin.settings.google-ads') }}" class="btn btn-primary"
                        style="background: var(--gradient-accent); box-shadow: 0 0 15px rgba(255, 0, 85, 0.4);">
                        <i class="fas fa-bullhorn"></i> Manage Ads
                    </a>
                    <a href="{{ route('home') }}" target="_blank" class="btn btn-outline">
                        <i class="fas fa-external-link-alt"></i> View Website
                    </a>
                </div>
            </div>

            <div class="card" style="border-color: rgba(255, 149, 0, 0.3);">
                <h3 class="card-title" style="margin-bottom: var(--spacing-md); color: var(--neon-warn);"><i
                        class="fas fa-info-circle"></i> Information</h3>
                <p class="card-description">
                    Use this admin panel to manage Google Analytics, Google Tag Manager, Google Ads, and other site-wide
                    settings.
                    Changes made here will be reflected immediately on the frontend.
                </p>
            </div>
        </div>
    </div>
@endsection