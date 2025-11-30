@props(['position' => 'top'])

<div class="container">
    <div class="ad-zone">
        <div class="ad-zone-label">Advertisement - {{ ucfirst($position) }}</div>
        <!-- Google AdSense code will go here -->
        <div
            style="min-height: 90px; display: flex; align-items: center; justify-content: center; color: var(--gray-400);">
            <p>[ Google AdSense Placeholder - 728x90 Leaderboard ]</p>
        </div>
    </div>
</div>