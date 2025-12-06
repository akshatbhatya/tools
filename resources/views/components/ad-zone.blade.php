@props(['position' => 'header'])

@php
    use App\Models\Setting;
    $googleAdsEnabled = Setting::get('google_ads_enabled', false);
    $googleAdsClient = Setting::get('google_ads_client');

    // Map position to slot setting key
    $slotMap = [
        'header' => 'google_ads_slot_header',
        'top' => 'google_ads_slot_header',
        'middle' => 'google_ads_slot_header',
        'sidebar' => 'google_ads_slot_sidebar',
        'footer' => 'google_ads_slot_footer',
        'bottom' => 'google_ads_slot_footer',
    ];

    $slotKey = $slotMap[$position] ?? 'google_ads_slot_header';
    $adSlot = Setting::get($slotKey);
@endphp

@if($googleAdsEnabled && $googleAdsClient && $adSlot)
    <div class="container">
        <div class="ad-zone">
            <div class="ad-zone-label">Advertisement</div>
            <!-- Google AdSense Ad Unit -->
            <ins class="adsbygoogle" style="display:block" data-ad-client="{{ $googleAdsClient }}"
                data-ad-slot="{{ $adSlot }}" data-ad-format="auto" data-full-width-responsive="true"></ins>
            <script>
                (adsbygoogle = window.adsbygoogle || []).push({});
            </script>
        </div>
    </div>
@endif