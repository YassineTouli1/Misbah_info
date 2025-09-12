<?php

namespace App\Http\Controllers\Manager\SettingController;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Setting;
use Illuminate\Support\Facades\Storage;
class UpdateSettingController extends Controller
{
    public function __invoke(Request $request)
    {
        $request->validate([
            'hero_title' => 'nullable|string',
            'hero_subtitle' => 'nullable|string',
            'logo' => 'nullable|image|max:2048',
            'facebook_link' => 'nullable|url',
            'instagram_link' => 'nullable|url',
            'whatsapp_link' => 'nullable|url',
            'phone' => 'nullable|string',
            'adresse' => 'nullable|string',
            'disponibilite' => 'nullable|string',
        ]);

        $settings = Setting::first();

        $settings->hero_title = $request->hero_title;
        $settings->hero_subtitle = $request->hero_subtitle;
        $settings->facebook_link = $request->facebook_link;
        $settings->instagram_link = $request->instagram_link;
        $settings->whatsapp_link = $request->whatsapp_link;
        $settings->phone = $request->phone;
        $settings->adresse = $request->adresse;
        $settings->disponibilite = $request->disponibilite;

        if ($request->hasFile('logo')) {
            if ($settings->logo_path) {
                Storage::disk('public')->delete($settings->logo_path);
            }
            $path = $request->file('logo')->store('logos', 'public');
            $settings->logo_path = $path;
        }

        $settings->save();

        return back()->with('success', 'Modifications enregistrées.');

    }

}
