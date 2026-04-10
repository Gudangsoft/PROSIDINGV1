<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class RegistrationPackage extends Model
{
    protected $fillable = [
        'conference_id', 'name', 'price', 'currency',
        'description', 'features', 'is_featured', 'is_free',
        'require_payment_proof', 'is_active', 'show_register_button', 'sort_order', 'participant_type_id',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'features' => 'array',
        'is_featured' => 'boolean',
        'is_free' => 'boolean',
        'require_payment_proof' => 'boolean',
        'is_active' => 'boolean',
        'show_register_button' => 'boolean',
    ];

    public function conference(): BelongsTo
    {
        return $this->belongsTo(Conference::class);
    }

    public function participantType(): BelongsTo
    {
        return $this->belongsTo(ParticipantType::class);
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function getFormattedPriceAttribute(): string
    {
        if ($this->is_free) return 'Gratis';
        
        $currencySymbol = match($this->currency ?? 'IDR') {
            'USD' => '$',
            'IDR' => 'Rp',
            default => $this->currency,
        };
        
        if ($this->currency === 'USD') {
            return $currencySymbol . ' ' . number_format($this->price, 2, '.', ',');
        }
        
        return $currencySymbol . '. ' . number_format($this->price, 0, ',', '.');
    }
}
