<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    /**
     * Show the admin login form
     */
    public function showLogin()
    {
        if (Auth::guard('admin')->check()) {
            return redirect()->route('admin.dashboard');
        }
        return view('admin.login');
    }

    /**
     * Handle admin login
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::guard('admin')->attempt($credentials, $request->filled('remember'))) {
            $request->session()->regenerate();
            return redirect()->intended(route('admin.dashboard'));
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }

    /**
     * Handle admin logout
     */
    public function logout(Request $request)
    {
        Auth::guard('admin')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('admin.login');
    }

    /**
     * Show the admin dashboard
     */
    public function dashboard()
    {
        $stats = [
            'total_settings' => Setting::count(),
            'google_tags' => Setting::where('group', 'google_tags')->count(),
            'google_ads' => Setting::where('group', 'google_ads')->count(),
        ];

        return view('admin.dashboard', compact('stats'));
    }

    /**
     * Show Google Tags settings
     */
    public function googleTags()
    {
        $settings = Setting::where('group', 'google_tags')->get()->keyBy('key');
        return view('admin.settings.google-tags', compact('settings'));
    }

    /**
     * Update Google Tags settings
     */
    public function updateGoogleTags(Request $request)
    {
        $request->validate([
            'google_analytics_id' => 'nullable|string',
            'google_tag_manager_id' => 'nullable|string',
            'google_site_verification' => 'nullable|string',
        ]);

        Setting::set('google_analytics_id', $request->google_analytics_id, 'google_tags', 'text');
        Setting::set('google_tag_manager_id', $request->google_tag_manager_id, 'google_tags', 'text');
        Setting::set('google_site_verification', $request->google_site_verification, 'google_tags', 'text');

        return back()->with('success', 'Google Tags settings updated successfully!');
    }

    /**
     * Show Google Ads settings
     */
    public function googleAds()
    {
        $settings = Setting::where('group', 'google_ads')->get()->keyBy('key');
        return view('admin.settings.google-ads', compact('settings'));
    }

    /**
     * Update Google Ads settings
     */
    public function updateGoogleAds(Request $request)
    {
        $request->validate([
            'google_ads_enabled' => 'nullable|boolean',
            'google_ads_client' => 'nullable|string',
            'google_ads_slot_header' => 'nullable|string',
            'google_ads_slot_sidebar' => 'nullable|string',
            'google_ads_slot_footer' => 'nullable|string',
        ]);

        Setting::set('google_ads_enabled', $request->has('google_ads_enabled'), 'google_ads', 'boolean');
        Setting::set('google_ads_client', $request->google_ads_client, 'google_ads', 'text');
        Setting::set('google_ads_slot_header', $request->google_ads_slot_header, 'google_ads', 'text');
        Setting::set('google_ads_slot_sidebar', $request->google_ads_slot_sidebar, 'google_ads', 'text');
        Setting::set('google_ads_slot_footer', $request->google_ads_slot_footer, 'google_ads', 'text');

        return back()->with('success', 'Google Ads settings updated successfully!');
    }
}
