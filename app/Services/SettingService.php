<?php

namespace App\Services;

use App\Models\M_Settings;
use Illuminate\Support\Facades\Cache;

class SettingService
{
    /**
     * Ambil semua settings
     */
    public function getAll(): array
    {
        return M_Settings::all()
            ->pluck('setting_value', 'setting_key')
            ->toArray();
    }

    /**
     * Ambil 1 setting by key
     */
    public function get(string $key, string $default = ''): string
    {
        $setting = M_Settings::where('setting_key', $key)->first();
        return $setting ? $setting->setting_value : $default;
    }

    /**
     * Update banyak settings sekaligus
     */
    public function updateMany(array $data): void
    {
        foreach ($data as $key => $value) {
            M_Settings::updateOrCreate(
                ['setting_key' => $key],
                ['setting_value' => $value]
            );
        }
    }
}