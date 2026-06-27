<?php

namespace App\Http\Controllers;

use App\Services\SettingService;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    protected SettingService $settingService;

    public function __construct(SettingService $settingService)
    {
        $this->settingService = $settingService;
    }

    public function index()
    {
        $settings = $this->settingService->getAll();

        return view('admin.settings.index', [
            'settings' => $settings,
        ]);
    }

    public function update(Request $request)
    {
        $request->validate([
            'bot_name'        => 'required|string|max:100',
            'welcome_message' => 'required|string|max:500',
            'max_session'     => 'required|integer|min:1|max:100',
            'ai_model'        => 'required|string',
            'contact_email'   => 'nullable|email',
            'contact_phone'   => 'nullable|string|max:20',
        ]);

        $this->settingService->updateMany([
            'bot_name'        => $request->bot_name,
            'welcome_message' => $request->welcome_message,
            'max_session'     => $request->max_session,
            'ai_model'        => $request->ai_model,
            'contact_email'   => $request->contact_email,
            'contact_phone'   => $request->contact_phone,
        ]);

        return redirect()->route('admin.settings.index')
            ->with('success', 'Pengaturan berhasil disimpan.');
    }
}