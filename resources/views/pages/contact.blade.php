@extends('layouts.app')

@section('content')
    <div class="container" style="padding: var(--spacing-xl) 20px; margin-top: 80px;">
        <div class="content-card" style="width: 100%; max-width: 600px; margin: 0 auto;">
            <h1
                style="text-align: center; margin-bottom: var(--spacing-lg); background: var(--gradient-primary); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">
                Contact Us</h1>

            <p style="text-align: center; color: var(--text-muted); margin-bottom: var(--spacing-xl);">
                Have a question, suggestion, or just want to say hi? We'd love to hear from you.
            </p>

            @if(session('success'))
                <div
                    style="background: rgba(0, 255, 157, 0.1); color: var(--neon-success); padding: var(--spacing-md); border-radius: var(--radius-sm); margin-bottom: var(--spacing-lg); border: 1px solid rgba(0, 255, 157, 0.2); display: flex; align-items: center; gap: 10px;">
                    <i class="fas fa-check-circle"></i> {{ session('success') }}
                </div>
            @endif

            <form action="{{ route('contact.submit') }}" method="POST">
                @csrf

                <div class="form-group" style="margin-bottom: var(--spacing-md);">
                    <label for="name"
                        style="display: block; margin-bottom: var(--spacing-xs); color: var(--text-muted);">Your
                        Name</label>
                    <input type="text" id="name" name="name" class="form-control" required value="{{ old('name') }}"
                        style="width: 100%; padding: 12px; background: rgba(255, 255, 255, 0.05); border: 1px solid rgba(255, 255, 255, 0.1); border-radius: var(--radius-sm); color: var(--text-main);">
                    @error('name')
                        <span
                            style="color: var(--neon-accent); font-size: 0.85rem; display: block; margin-top: 5px;">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group" style="margin-bottom: var(--spacing-md);">
                    <label for="email"
                        style="display: block; margin-bottom: var(--spacing-xs); color: var(--text-muted);">Email
                        Address</label>
                    <input type="email" id="email" name="email" class="form-control" required value="{{ old('email') }}"
                        style="width: 100%; padding: 12px; background: rgba(255, 255, 255, 0.05); border: 1px solid rgba(255, 255, 255, 0.1); border-radius: var(--radius-sm); color: var(--text-main);">
                    @error('email')
                        <span
                            style="color: var(--neon-accent); font-size: 0.85rem; display: block; margin-top: 5px;">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group" style="margin-bottom: var(--spacing-md);">
                    <label for="subject"
                        style="display: block; margin-bottom: var(--spacing-xs); color: var(--text-muted);">Subject</label>
                    <input type="text" id="subject" name="subject" class="form-control" required
                        value="{{ old('subject') }}"
                        style="width: 100%; padding: 12px; background: rgba(255, 255, 255, 0.05); border: 1px solid rgba(255, 255, 255, 0.1); border-radius: var(--radius-sm); color: var(--text-main);">
                    @error('subject')
                        <span
                            style="color: var(--neon-accent); font-size: 0.85rem; display: block; margin-top: 5px;">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group" style="margin-bottom: var(--spacing-lg);">
                    <label for="message"
                        style="display: block; margin-bottom: var(--spacing-xs); color: var(--text-muted);">Message</label>
                    <textarea id="message" name="message" rows="5" class="form-control" required
                        style="width: 100%; padding: 12px; background: rgba(255, 255, 255, 0.05); border: 1px solid rgba(255, 255, 255, 0.1); border-radius: var(--radius-sm); color: var(--text-main);">{{ old('message') }}</textarea>
                    @error('message')
                        <span
                            style="color: var(--neon-accent); font-size: 0.85rem; display: block; margin-top: 5px;">{{ $message }}</span>
                    @enderror
                </div>

                <button type="submit" class="btn btn-primary" style="width: 100%; padding: 14px; font-size: 1.1rem;">
                    <i class="fas fa-paper-plane"></i> Send Message
                </button>
            </form>
        </div>
    </div>
@endsection