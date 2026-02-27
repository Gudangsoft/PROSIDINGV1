<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Paper extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'conference_id', 'assigned_editor_id', 'title', 'abstract', 'keywords', 'topic',
        'authors_meta', 'status', 'editor_notes', 'loa_link', 'loa_number', 'article_link', 'video_presentation_url', 'submitted_at', 'accepted_at',
    ];

    protected $casts = [
        'authors_meta' => 'array',
        'submitted_at' => 'datetime',
        'accepted_at' => 'datetime',
    ];

    const STATUS_LABELS = [
        'submitted' => 'Submitted',
        'screening' => 'Screening',
        'in_review' => 'In Review',
        'revision_required' => 'Revision Required',
        'revised' => 'Revised',
        'accepted' => 'Accepted',
        'rejected' => 'Rejected',
        'payment_pending' => 'Menunggu Pembayaran',
        'payment_uploaded' => 'Pembayaran Diupload',
        'payment_verified' => 'Pembayaran Terverifikasi',
        'deliverables_pending' => 'Menunggu Luaran',
        'completed' => 'Completed',
    ];

    const STATUS_COLORS = [
        'submitted' => 'blue',
        'screening' => 'yellow',
        'in_review' => 'indigo',
        'revision_required' => 'orange',
        'revised' => 'cyan',
        'accepted' => 'green',
        'rejected' => 'red',
        'payment_pending' => 'amber',
        'payment_uploaded' => 'purple',
        'payment_verified' => 'emerald',
        'deliverables_pending' => 'teal',
        'completed' => 'green',
    ];

    public function getStatusLabelAttribute(): string
    {
        return self::STATUS_LABELS[$this->status] ?? $this->status;
    }

    /**
     * Generate correct LOA URL regardless of how/when it was stored.
     * - Relative paths  → asset('storage/<path>')
     * - Legacy full URLs pointing to /storage/loa/ → re-generate from current APP_URL
     * - Manual (Google Drive, etc.) full URLs → return as-is
     */
    public function getLoaUrlAttribute(): ?string
    {
        if (!$this->loa_link) return null;

        // Already a full URL
        if (str_starts_with($this->loa_link, 'http://') || str_starts_with($this->loa_link, 'https://')) {
            // If it's an auto-generated storage file, extract relative path and rebuild URL
            if (preg_match('#/storage/(loa/.+\.pdf)$#', $this->loa_link, $m)) {
                return asset('storage/' . $m[1]);
            }
            // Manual link (Google Drive, Dropbox, etc.) – return as-is
            return $this->loa_link;
        }

        // Relative path (new format)
        return asset('storage/' . $this->loa_link);
    }

    public function getStatusColorAttribute(): string
    {
        return self::STATUS_COLORS[$this->status] ?? 'gray';
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function conference(): BelongsTo
    {
        return $this->belongsTo(Conference::class);
    }

    public function assignedEditor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'assigned_editor_id');
    }

    public function files(): HasMany
    {
        return $this->hasMany(PaperFile::class);
    }

    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class);
    }

    public function payment(): HasOne
    {
        return $this->hasOne(Payment::class);
    }

    public function deliverables(): HasMany
    {
        return $this->hasMany(Deliverable::class);
    }

    public function discussions(): HasMany
    {
        return $this->hasMany(Discussion::class);
    }

    public function latestFullPaper()
    {
        return $this->files()->whereIn('type', ['full_paper', 'revision'])->latest()->first();
    }
}
