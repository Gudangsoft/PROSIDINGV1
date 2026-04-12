<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class WaBlast extends Model
{
    protected $fillable = [
        'title',
        'recipient_type',
        'recipient_role',
        'phone_numbers',
        'message',
        'status',
        'total_recipients',
        'sent_count',
        'failed_count',
        'error_log',
        'created_by',
        'sent_at',
    ];

    protected $casts = [
        'phone_numbers' => 'array',
        'sent_at'       => 'datetime',
    ];

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function getStatusLabelAttribute(): string
    {
        return match ($this->status) {
            'draft'     => 'Draft',
            'sending'   => 'Mengirim...',
            'completed' => 'Selesai',
            'failed'    => 'Gagal',
            default     => ucfirst($this->status),
        };
    }

    public function getStatusColorAttribute(): string
    {
        return match ($this->status) {
            'draft'     => 'gray',
            'sending'   => 'yellow',
            'completed' => 'green',
            'failed'    => 'red',
            default     => 'gray',
        };
    }

    public function getSuccessRateAttribute(): int
    {
        if ($this->total_recipients === 0) return 0;
        return (int) round(($this->sent_count / $this->total_recipients) * 100);
    }
}
