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

    /**
     * Show Pages list
     */
    public function pages()
    {
        $pages = \App\Models\Page::all();
        return view('admin.pages.index', compact('pages'));
    }

    /**
     * Show Edit Page form
     */
    public function editPage($id)
    {
        $page = \App\Models\Page::findOrFail($id);
        return view('admin.pages.edit', compact('page'));
    }

    /**
     * Update Page
     */
    public function updatePage(Request $request, $id)
    {
        $page = \App\Models\Page::findOrFail($id);

        $request->validate([
            'title' => 'nullable|string|max:255',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string',
            'meta_keywords' => 'nullable|string',
            'canonical_url' => 'nullable|url',
            'og_image' => 'nullable|url',
            'schema_markup' => 'nullable|string',
        ]);

        $page->update($request->only([
            'title',
            'meta_title',
            'meta_description',
            'meta_keywords',
            'canonical_url',
            'og_image',
            'schema_markup'
        ]));

        return redirect()->route('admin.pages.index')->with('success', 'Page SEO updated successfully!');
    }
    /**
     * Sync Pages from Routes
     */
    public function syncPages()
    {
        $routes = \Illuminate\Support\Facades\Route::getRoutes();
        $addedCount = 0;

        foreach ($routes as $route) {
            $routeName = $route->getName();

            // Skip routes without names, admin routes, api routes, and debugbar routes
            if (
                !$routeName ||
                str_starts_with($routeName, 'admin.') ||
                str_starts_with($routeName, 'sanctum.') ||
                str_starts_with($routeName, 'ignition.') ||
                str_starts_with($routeName, '_debugbar.') ||
                str_starts_with($routeName, 'livewire.')
            ) {
                continue;
            }

            // Check if page already exists
            if (!\App\Models\Page::where('route_name', $routeName)->exists()) {
                // Create new page entry
                \App\Models\Page::create([
                    'route_name' => $routeName,
                    'title' => ucwords(str_replace(['.', '-', '_'], ' ', $routeName)),
                    'meta_title' => ucwords(str_replace(['.', '-', '_'], ' ', $routeName)) . ' - ToolsHub',
                    'meta_description' => 'Default description for ' . $routeName,
                ]);
                $addedCount++;
            }
        }

        return back()->with('success', "Synced successfully! $addedCount new pages added.");
    }

    /**
     * Show Contacts list
     */
    public function contacts()
    {
        $contacts = \App\Models\Contact::latest()->paginate(10);
        return view('admin.contacts.index', compact('contacts'));
    }

    /**
     * Show Edit Contact form
     */
    public function editContact($id)
    {
        $contact = \App\Models\Contact::findOrFail($id);
        return view('admin.contacts.edit', compact('contact'));
    }

    /**
     * Update Contact status
     */
    public function updateContact(Request $request, $id)
    {
        $contact = \App\Models\Contact::findOrFail($id);

        $request->validate([
            'status' => 'required|in:new,read,replied',
        ]);

        $contact->update(['status' => $request->status]);

        return redirect()->route('admin.contacts.index')->with('success', 'Contact status updated successfully!');
    }

    /**
     * Delete Contact
     */
    public function deleteContact($id)
    {
        $contact = \App\Models\Contact::findOrFail($id);
        $contact->delete();

        return redirect()->route('admin.contacts.index')->with('success', 'Contact message deleted successfully!');
    }
}
