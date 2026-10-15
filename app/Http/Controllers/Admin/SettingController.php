<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SettingController extends Controller
{
    /** group => [key => [label, type]] */
    public const GROUPS = [
        'General' => [
            'site_name' => ['Company Name', 'text'],
            'tagline' => ['Tagline', 'text'],
            'site_slogan' => ['Home Slogan', 'text'],
            'website' => ['Website', 'text'],
            'footer_text' => ['Footer Text', 'textarea'],
        ],
        'Branding' => [
            'logo' => ['Logo', 'image'],
            'logo_light' => ['Logo (light, for dark background)', 'image'],
            'favicon' => ['Favicon', 'image'],
        ],
        'Contact' => [
            'phone' => ['Phone', 'text'],
            'alt_phone' => ['Alternate Mobile Number', 'text'],
            'whatsapp' => ['WhatsApp Number (with country code)', 'text'],
            'email' => ['Email', 'text'],
            'address' => ['Address', 'textarea'],
            'map_embed' => ['Google Map Embed URL', 'text'],
        ],
        'Social' => [
            'facebook' => ['Facebook URL', 'text'],
            'instagram' => ['Instagram URL', 'text'],
            'linkedin' => ['LinkedIn URL', 'text'],
            'youtube' => ['YouTube URL', 'text'],
        ],
        'SEO' => [
            'meta_title' => ['Default Meta Title', 'text'],
            'meta_description' => ['Default Meta Description', 'textarea'],
        ],
        'Catalogue' => [
            'catalogue_pdf' => ['Catalogue PDF', 'file'],
            'show_prices' => ['Show M.R.P. on website', 'checkbox'],
        ],
    ];

    public function edit()
    {
        return view('admin.settings', ['groups' => self::GROUPS, 'values' => Setting::all_values()]);
    }

    public function update(Request $request)
    {
        $request->validate([
            'logo' => 'nullable|image|max:4096',
            'logo_light' => 'nullable|image|max:4096',
            'favicon' => 'nullable|image|max:1024',
            'catalogue_pdf' => 'nullable|file|mimes:pdf|max:51200',
        ]);

        foreach (self::GROUPS as $fields) {
            foreach ($fields as $key => [$label, $type]) {
                if ($type === 'image' || $type === 'file') {
                    if ($request->hasFile($key)) {
                        if ($old = Setting::get($key)) {
                            Storage::disk('public')->delete($old);
                        }
                        Setting::put($key, $request->file($key)->store('settings', 'public'));
                    }
                } elseif ($type === 'checkbox') {
                    Setting::put($key, $request->boolean($key) ? '1' : '0');
                } else {
                    Setting::put($key, $request->input($key));
                }
            }
        }

        return back()->with('success', 'Settings saved.');
    }
}
