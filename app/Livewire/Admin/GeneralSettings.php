<?php

namespace App\Livewire\Admin;

use App\Models\Setting;
use App\Models\ThemePreset;
use App\Helpers\Template;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;

class GeneralSettings extends Component
{
    use WithFileUploads;

    public array $settings = [];
    public $siteLogo = null;
    public $siteFavicon = null;
    public $activePresetId = null;

    public function mount()
    {
        $models = Setting::byGroup('general')->get();
        foreach ($models as $setting) {
            $this->settings[$setting->key] = $setting->value ?? '';
        }

        // Default for show_tagline_in_sidebar if not yet in DB
        if (!isset($this->settings['show_tagline_in_sidebar'])) {
            $this->settings['show_tagline_in_sidebar'] = '1';
        }

        // Load current active theme preset
        $activePreset = ThemePreset::where('is_active', true)->first();
        $this->activePresetId = $activePreset?->id;
    }

    public function save()
    {
        $this->validate([
            'settings.site_name' => 'required|string|max:255',
            'settings.contact_email' => 'nullable|email|max:255',
            'siteLogo' => 'nullable|image|max:2048',
            'siteFavicon' => 'nullable|image|max:1024',
        ]);

        foreach ($this->settings as $key => $value) {
            Setting::setValue($key, $value);
        }

        // Activate selected theme preset
        if ($this->activePresetId) {
            $preset = ThemePreset::find($this->activePresetId);
            if ($preset) {
                ThemePreset::where('is_active', true)->update(['is_active' => false]);
                $preset->update(['is_active' => true]);
                if ($preset->linked_template) {
                    Setting::setValue('active_template', $preset->linked_template);
                    $this->settings['active_template'] = $preset->linked_template;
                }
                // Sync theme colors to old settings for backward compat
                $map = [
                    'primary_color' => 'theme_primary_color',
                    'secondary_color' => 'theme_secondary_color',
                    'accent_color' => 'theme_accent_color',
                    'sidebar_bg' => 'theme_sidebar_bg',
                    'sidebar_text' => 'theme_sidebar_text',
                    'header_bg' => 'theme_header_bg',
                    'body_bg' => 'theme_body_bg',
                    'font_family' => 'theme_font_family',
                    'border_radius' => 'theme_border_radius',
                    'custom_css' => 'theme_custom_css',
                    'login_bg_image' => 'theme_login_bg_image',
                ];
                foreach ($map as $presetField => $settingKey) {
                    Setting::setValue($settingKey, $preset->$presetField ?? '');
                }
            }
        }

        if ($this->siteLogo) {
            // public_path('uploads/settings') used to be written to directly
            // here — a single folder shared by every tenant (public_path()
            // isn't affected by tenant-suffixed storage paths at all), so
            // any two tenants uploading a logo could silently overwrite each
            // other's file. Now saved through the 'public' disk, which
            // FilesystemTenancyBootstrapper correctly roots per tenant.
            $old = Setting::getValue('site_logo');
            if ($old) {
                $this->deleteOldSettingFile($old);
            }

            $filename = 'logo_' . uniqid() . '.' . $this->siteLogo->getClientOriginalExtension();
            $path = $this->siteLogo->storeAs('settings', $filename, 'public');

            Setting::setValue('site_logo', $path);
            $this->settings['site_logo'] = $path;
            $this->siteLogo = null;
        }

        if ($this->siteFavicon) {
            $old = Setting::getValue('site_favicon');
            if ($old) {
                $this->deleteOldSettingFile($old);
            }

            $filename = 'favicon_' . uniqid() . '.' . $this->siteFavicon->getClientOriginalExtension();
            $path = $this->siteFavicon->storeAs('settings', $filename, 'public');

            Setting::setValue('site_favicon', $path);
            $this->settings['site_favicon'] = $path;
            $this->siteFavicon = null;
        }

        session()->flash('success', 'Pengaturan website berhasil disimpan.');
    }

    public function removeLogo()
    {
        $old = Setting::getValue('site_logo');
        if ($old) {
            $this->deleteOldSettingFile($old);
        }
        Setting::setValue('site_logo', null);
        $this->settings['site_logo'] = '';
        $this->siteLogo = null;
    }

    public function removeFavicon()
    {
        $old = Setting::getValue('site_favicon');
        if ($old) {
            $this->deleteOldSettingFile($old);
        }
        Setting::setValue('site_favicon', null);
        $this->settings['site_favicon'] = '';
        $this->siteFavicon = null;
    }

    /**
     * Deletes a previously stored logo/favicon, regardless of which format
     * it was saved under: the legacy shared public_path('uploads/...')
     * location, or the current tenant-aware 'public' disk location.
     */
    private function deleteOldSettingFile(string $path): void
    {
        if (str_starts_with($path, 'uploads/')) {
            $oldPath = public_path($path);
            if (file_exists($oldPath)) {
                @unlink($oldPath);
            }
            return;
        }

        if (Storage::disk('public')->exists($path)) {
            Storage::disk('public')->delete($path);
        }
    }

    public function render()
    {
        $themePresets = ThemePreset::orderByDesc('is_active')->orderByDesc('is_default')->orderBy('name')->get();
        return view('livewire.admin.general-settings', compact('themePresets'))->layout('layouts.app');
    }
}
