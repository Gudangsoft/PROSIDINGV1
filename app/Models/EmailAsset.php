<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;

class EmailAsset extends Model
{
    protected $fillable = [
        'conference_id',
        'name',
        'type',
        'url',
        'description',
        'is_global',
    ];

    protected $casts = [
        'is_global' => 'boolean',
    ];

    public function conference(): BelongsTo
    {
        return $this->belongsTo(Conference::class);
    }

    /**
     * Full public URL for the asset (resolves storage paths).
     */
    public function publicUrl(): string
    {
        if ($this->type === 'file') {
            return Storage::url($this->url);
        }
        return $this->url;
    }

    /**
     * Get assets available for a given conference (own + global).
     */
    public static function forConference(?int $conferenceId)
    {
        return static::where(function ($q) use ($conferenceId) {
            if ($conferenceId) {
                $q->where('conference_id', $conferenceId)->orWhere('is_global', true);
            } else {
                $q->where('is_global', true);
            }
        })->orderByDesc('created_at')->get();
    }
}
