<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Payment extends Model
{
    protected $fillable = [
        'type', 'paper_id', 'registration_package_id', 'user_id', 'invoice_number', 'amount',
        'description', 'status', 'payment_proof', 'payment_method',
        'paid_at', 'verified_by', 'verified_at', 'admin_notes',
    ];

    protected $casts = [
        'paid_at' => 'datetime',
        'verified_at' => 'datetime',
        'amount' => 'decimal:2',
    ];

    // Type constants
    const TYPE_PAPER = 'paper';
    const TYPE_PARTICIPANT = 'participant';

    public function paper(): BelongsTo
    {
        return $this->belongsTo(Paper::class);
    }

    public function registrationPackage(): BelongsTo
    {
        return $this->belongsTo(RegistrationPackage::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function verifier(): BelongsTo
    {
        return $this->belongsTo(User::class, 'verified_by');
    }

    public static function generateInvoiceNumber(): string
    {
        $prefix = 'INV-' . date('Ymd');
        $lastPayment = self::where('invoice_number', 'like', $prefix . '%')
                           ->orderBy('id', 'desc')
                           ->first();
                           
        if ($lastPayment) {
            $lastNumber = (int) substr($lastPayment->invoice_number, strrpos($lastPayment->invoice_number, '-') + 1);
            $newNumber = $lastNumber + 1;
        } else {
            $newNumber = 1;
        }
        
        $invoiceNumber = $prefix . '-' . str_pad($newNumber, 4, '0', STR_PAD_LEFT);
        
        // Loop just to be absolutely sure in case of edge cases
        while (self::where('invoice_number', $invoiceNumber)->exists()) {
            $newNumber++;
            $invoiceNumber = $prefix . '-' . str_pad($newNumber, 4, '0', STR_PAD_LEFT);
        }
        
        return $invoiceNumber;
    }

    public function getFormattedAmountAttribute(): string
    {
        // Get currency from related registration package if available
        $currency = 'IDR';
        if ($this->registrationPackage) {
            $currency = $this->registrationPackage->currency ?? 'IDR';
        }

        $currencySymbol = match($currency) {
            'USD' => '$',
            'IDR' => 'Rp',
            default => $currency,
        };

        if ($currency === 'USD') {
            return $currencySymbol . ' ' . number_format($this->amount, 2, '.', ',');
        }

        return $currencySymbol . '. ' . number_format($this->amount, 0, ',', '.');
    }
}
