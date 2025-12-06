@extends('admin.layout')

@section('title', 'View Message')
@section('page-title', 'View Message')

@section('content')
    <div class="content-card" style="max-width: 800px;">
        <div
            style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: var(--spacing-lg);">
            <div>
                <h2 style="margin-bottom: var(--spacing-xs); color: var(--text-main);">{{ $contact->subject }}</h2>
                <p style="color: var(--text-muted); font-size: 0.9rem;">
                    From: <strong style="color: var(--text-main);">{{ $contact->name }}</strong>
                    &lt;{{ $contact->email }}&gt;
                    <br>
                    Date: {{ $contact->created_at->format('M d, Y h:i A') }}
                </p>
            </div>
            <a href="{{ route('admin.contacts.index') }}" class="btn"
                style="background: rgba(255, 255, 255, 0.1); color: var(--text-main); padding: 8px 16px; border-radius: 4px; text-decoration: none;">
                <i class="fas fa-arrow-left"></i> Back
            </a>
        </div>

        <div
            style="background: rgba(255, 255, 255, 0.03); padding: var(--spacing-lg); border-radius: var(--radius-sm); border: 1px solid rgba(255, 255, 255, 0.05); margin-bottom: var(--spacing-xl); white-space: pre-wrap; line-height: 1.6;">
            {{ $contact->message }}</div>

        <form action="{{ route('admin.contacts.update', $contact->id) }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="status">Update Status</label>
                <select name="status" id="status" class="form-control" style="max-width: 200px;">
                    <option value="new" {{ $contact->status == 'new' ? 'selected' : '' }}>New</option>
                    <option value="read" {{ $contact->status == 'read' ? 'selected' : '' }}>Read</option>
                    <option value="replied" {{ $contact->status == 'replied' ? 'selected' : '' }}>Replied</option>
                </select>
            </div>

            <button type="submit" class="btn btn-primary">
                <i class="fas fa-save"></i> Update Status
            </button>

            <a href="mailto:{{ $contact->email }}?subject=Re: {{ $contact->subject }}" class="btn"
                style="background: var(--neon-primary); color: #000; padding: 10px 20px; border-radius: 4px; text-decoration: none; margin-left: 10px; font-weight: 600;">
                <i class="fas fa-reply"></i> Reply via Email
            </a>
        </form>
    </div>
@endsection