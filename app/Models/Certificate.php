<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Certificate extends Model
{
    protected $fillable = [
        'cert_number',
        'type',
        'user_id',
        'paper_id',
        'conference_id',
        'file_path',
        'generated_at',
    ];

    protected $casts = [
        'generated_at' => 'datetime',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function paper(): BelongsTo
    {
        return $this->belongsTo(Paper::class);
    }

    public function conference(): BelongsTo
    {
        return $this->belongsTo(Conference::class);
    }

    public function getTypeLabel(): string
    {
        return match($this->type) {
            'author'      => 'Pemakalah / Author',
            'participant' => 'Peserta / Participant',
            'reviewer'    => 'Reviewer',
            'committee'   => 'Panitia / Committee',
            default       => ucfirst($this->type),
        };
    }
}
