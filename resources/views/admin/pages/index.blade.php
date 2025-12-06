@extends('admin.layout')

@section('title', 'SEO Pages Manager')
@section('page-title', 'SEO Pages Manager')

@section('content')
    <div class="content-card">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: var(--spacing-xl);">
            <div>
                <h2 style="margin-bottom: var(--spacing-sm);"><i class="fas fa-search"
                        style="color: var(--neon-primary);"></i> SEO
                    Pages Configuration</h2>
                <p style="color: var(--text-muted);">Manage meta titles, descriptions, and schema
                    markup for your pages.</p>
            </div>
            <form action="{{ route('admin.pages.sync') }}" method="POST">
                @csrf
                <button type="submit" class="btn btn-primary" style="display: flex; align-items: center; gap: 8px;">
                    <i class="fas fa-sync"></i> Sync New Pages
                </button>
            </form>
        </div>

        <div class="table-responsive" style="overflow-x: auto;">
            <table style="width: 100%; border-collapse: collapse; color: var(--text-main);">
                <thead>
                    <tr style="border-bottom: 1px solid rgba(255, 255, 255, 0.1);">
                        <th style="text-align: left; padding: var(--spacing-md); color: var(--text-muted);">Route Name</th>
                        <th style="text-align: left; padding: var(--spacing-md); color: var(--text-muted);">Page Title</th>
                        <th style="text-align: left; padding: var(--spacing-md); color: var(--text-muted);">Meta Description
                        </th>
                        <th style="text-align: right; padding: var(--spacing-md); color: var(--text-muted);">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($pages as $page)
                        <tr style="border-bottom: 1px solid rgba(255, 255, 255, 0.05); transition: background 0.2s;"
                            onmouseover="this.style.background='rgba(255, 255, 255, 0.02)'"
                            onmouseout="this.style.background='transparent'">
                            <td style="padding: var(--spacing-md);">
                                <span
                                    style="background: rgba(0, 242, 255, 0.1); color: var(--neon-primary); padding: 4px 8px; border-radius: 4px; font-size: 0.85rem;">
                                    {{ $page->route_name }}
                                </span>
                            </td>
                            <td style="padding: var(--spacing-md);">{{ $page->title }}</td>
                            <td
                                style="padding: var(--spacing-md); color: var(--text-muted); max-width: 300px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                                {{ $page->meta_description }}
                            </td>
                            <td style="padding: var(--spacing-md); text-align: right;">
                                <a href="{{ route('admin.pages.edit', $page->id) }}" class="btn btn-sm"
                                    style="background: var(--gradient-glow); color: var(--bg-deep); padding: 6px 12px; border-radius: 4px; text-decoration: none; font-weight: 600; font-size: 0.85rem;">
                                    <i class="fas fa-edit"></i> Edit
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection