<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Services\SettingsService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SettingsController extends Controller
{
    protected $settingsService;

    public function __construct(SettingsService $settingsService)
    {
        $this->settingsService = $settingsService;
    }

    public function index()
    {
        $settings = $this->settingsService->getAllSettings();
        return response()->json($settings);
    }

    public function store(Request $request)
    {
        // --- UPDATED VALIDATION RULES ---
        $validator = Validator::make($request->all(), [
            // General Settings
            'general.app_name' => 'required|string|max:255',
            'general.app_url' => 'required|url',
            'general.logo_url' => 'nullable|string|max:255',
            'general.favicon_url' => 'nullable|string|max:255',
            'general.support_email' => 'required|email',
            'general.maintenance_mode' => 'required|boolean',
            'general.maintenance_message' => 'nullable|string|max:1000',
            'general.copyright_text' => 'nullable|string|max:255',

            // Contact Settings
            'contact.public_email' => 'required|email',
            'contact.phone_number' => 'nullable|string|max:20',
            'contact.whatsapp_number' => 'nullable|string|max:20',
            'contact.address_line_1' => 'nullable|string|max:255',
            'contact.google_maps_url' => 'nullable|url',
            'contact.working_hours' => 'nullable|string|max:255',

            // Social Media Settings
            'social.facebook_url' => 'nullable|url',
            'social.instagram_url' => 'nullable|url',
            'social.twitter_url' => 'nullable|url',
            'social.pinterest_url' => 'nullable|url',
            'social.tiktok_url' => 'nullable|url',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $settingsData = $validator->validated();
        $success = $this->settingsService->saveSettings($settingsData);

        if ($success) {
            return response()->json(['message' => 'Settings saved successfully.']);
        }

        return response()->json(['message' => 'Failed to save one or more settings files.'], 500);
    }
}
