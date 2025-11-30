@props(['icon', 'title', 'description', 'url', 'gradient' => 'primary'])

@php
    $gradients = [
        'primary' => 'var(--gradient-primary)',
        'secondary' => 'var(--gradient-secondary)',
        'accent' => 'var(--gradient-accent)',
        'warm' => 'var(--gradient-warm)',
        'cool' => 'var(--gradient-cool)',
    ];
    $gradientValue = $gradients[$gradient] ?? $gradients['primary'];
@endphp

<a href="{{ url($url) }}" class="card tool-card">
    <div class="card-icon" style="background: {{ $gradientValue }};">
        <i class="{{ $icon }}"></i>
    </div>
    <h3 class="card-title">{{ $title }}</h3>
    <p class="card-description">{{ $description }}</p>
    <span style="color: var(--primary-500); font-weight: 600;">
        Use Tool →
    </span>
</a>