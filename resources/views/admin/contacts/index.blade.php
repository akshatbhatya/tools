@extends('admin.layout')

@section('title', 'Contact Messages')
@section('page-title', 'Contact Messages')

@section('content')
    <div class="content-card">
        <h2 style="margin-bottom: var(--spacing-sm);"><i class="fas fa-envelope" style="color: var(--neon-primary);"></i> Inbox</h2>
        <p style="color: var(--text-muted); margin-bottom: var(--spacing-xl);">View and manage messages from the contact form.</p>

        <div class="table-responsive" style="overflow-x: auto;">
            <table style="width: 100%; border-collapse: collapse; color: var(--text-main);">
                <thead>
                    <tr style="border-bottom: 1px solid rgba(255, 255, 255, 0.1);">
                        <th style="text-align: left; padding: var(--spacing-md); color: var(--text-muted);">Date</th>
                        <th style="text-align: left; padding: var(--spacing-md); color: var(--text-muted);">Name</th>
                        <th style="text-align: left; padding: var(--spacing-md); color: var(--text-muted);">Subject</th>
                        <th style="text-align: left; padding: var(--spacing-md); color: var(--text-muted);">Status</th>
                        <th style="text-align: right; padding: var(--spacing-md); color: var(--text-muted);">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($contacts as $contact)
                        <tr style="border-bottom: 1px solid rgba(255, 255, 255, 0.05); transition: background 0.2s;"
                            onmouseover="this.style.background='rgba(255, 255, 255, 0.02)'"
                            onmouseout="this.style.background='transparent'">
                            <td style="padding: var(--spacing-md); white-space: nowrap;">{{ $contact->created_at->format('M d, Y') }}</td>
                            <td style="padding: var(--spacing-md);">
                                <div>{{ $contact->name }}</div>
                                <div style="font-size: 0.8rem; color: var(--text-muted);">{{ $contact->email }}</div>
                            </td>
                            <td style="padding: var(--spacing-md);">{{ $contact->subject }}</td>
                            <td style="padding: var(--spacing-md);">
                                @if($contact->status == 'new')
                                    <span style="background: rgba(0, 242, 255, 0.1); color: var(--neon-primary); padding: 4px 8px; border-radius: 4px; font-size: 0.75rem; text-transform: uppercase;">New</span>
                                @elseif($contact->status == 'read')
                                    <span style="background: rgba(255, 255, 255, 0.1); color: var(--text-muted); padding: 4px 8px; border-radius: 4px; font-size: 0.75rem; text-transform: uppercase;">Read</span>
                                @else
                                    <span style="background: rgba(0, 255, 157, 0.1); color: var(--neon-success); padding: 4px 8px; border-radius: 4px; font-size: 0.75rem; text-transform: uppercase;">Replied</span>
                                @endif
                            </td>
                            <td style="padding: var(--spacing-md); text-align: right;">
                                <div style="display: flex; justify-content: flex-end; gap: 8px;">
                                    <a href="{{ route('admin.contacts.edit', $contact->id) }}" class="btn btn-sm"
                                        style="background: rgba(255, 255, 255, 0.1); color: var(--text-main); padding: 6px 10px; border-radius: 4px; text-decoration: none;">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <form action="{{ route('admin.contacts.delete', $contact->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this message?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm"
                                            style="background: rgba(255, 0, 85, 0.1); color: var(--neon-accent); padding: 6px 10px; border-radius: 4px; border: none; cursor: pointer;">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        
        <div style="margin-top: var(--spacing-lg);">
            {{ $contacts->links() }}
        </div>
    </div>
@endsection
