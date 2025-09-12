<?php

namespace App\Http\Controllers\Manager\SettingController;

use App\Http\Controllers\Controller;
use App\Models\Setting;
class EditSettingController extends Controller
{

    public function __invoke()
    {

        $settings = Setting::first();

        // Si aucun enregistrement n'existe encore, on en crée un vide
        if (!$settings) {
            $settings = Setting::create([
                'hero_title' => '',
                'hero_subtitle' => '',
                'logo_path' => '',
                'facebook_link' => null,
                'instagram_link' => null,
                'whatsapp_link' => null,
                'phone' => '',
                'adresse' => '',
                'disponibilite' => '',
            ]);
        }
        return view('dashboard.setting.setting_site', compact('settings'));
    }
}
