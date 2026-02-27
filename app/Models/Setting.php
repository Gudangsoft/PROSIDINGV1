<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $fillable = [
        'group', 'key', 'value', 'type', 'label', 'description', 'options', 'sort_order',
    ];

    protected $casts = [
        'options' => 'array',
    ];

    // ── Get value by key ──
    public static function getValue(string $key, $default = null)
    {
        $setting = static::where('key', $key)->first();
        if (!$setting) return $default;

        return match ($setting->type) {
            'boolean' => (bool) $setting->value,
            'number'  => (int) $setting->value,
            'json'    => json_decode($setting->value, true),
            default   => $setting->value,
        };
    }

    // ── Set value by key ──
    public static function setValue(string $key, $value, ?string $group = 'general', ?string $type = 'text', ?string $label = null): void
    {
        static::updateOrCreate(
            ['key' => $key],
            ['value' => is_array($value) ? json_encode($value) : $value, 'group' => $group, 'type' => $type, 'label' => $label ?? ucwords(str_replace('_', ' ', $key))]
        );
    }

    // ── Get all settings by group ──
    public static function getGroup(string $group): array
    {
        return static::where('group', $group)
            ->orderBy('sort_order')
            ->get()
            ->pluck('value', 'key')
            ->toArray();
    }

    // ── Scope ──
    public function scopeByGroup($query, string $group)
    {
        return $query->where('group', $group)->orderBy('sort_order');
    }

    // ── Helper for logo/favicon URLs ──
    public static function getLogoUrl(): ?string
    {
        $logo = static::getValue('site_logo');
        if (!$logo) return null;
        
        // New format: uploads/settings/...
        if (str_starts_with($logo, 'uploads/')) {
            return asset($logo);
        }
        // Old format: settings/... (needs storage/)
        return asset('storage/' . $logo);
    }

    public static function getFaviconUrl(): ?string
    {
        $favicon = static::getValue('site_favicon');
        if (!$favicon) return null;
        
        if (str_starts_with($favicon, 'uploads/')) {
            return asset($favicon);
        }
        return asset('storage/' . $favicon);
    }

    // ── GROUP CONSTANTS ──
    const GROUP_GENERAL = 'general';
    const GROUP_EMAIL = 'email';
    const GROUP_THEME = 'theme';

    const GROUPS = [
        'general' => 'Umum',
        'email' => 'Email',
        'theme' => 'Tema',
    ];
}
