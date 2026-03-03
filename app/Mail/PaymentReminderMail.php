<?php

namespace App\Mail;

use App\Models\EmailTemplate;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PaymentReminderMail extends Mailable
{
    use Queueable, SerializesModels;

    public string $userName;
    public string $invoiceNumber;
    public int|float $amount;
    public string $currency;
    public string $paymentUrl;
    public string $loginUrl;
    public ?int $conferenceId;

    public function __construct(
        string $userName,
        string $invoiceNumber,
        int|float $amount,
        string $paymentUrl,
        ?int $conferenceId = null,
        string $currency = 'IDR'
    ) {
        $this->userName     = $userName;
        $this->invoiceNumber = $invoiceNumber;
        $this->amount       = $amount;
        $this->currency     = $currency;
        $this->paymentUrl   = $paymentUrl;
        $this->loginUrl     = route('login');
        $this->conferenceId = $conferenceId;
    }

    public function build(): static
    {
        $tpl = EmailTemplate::forConference($this->conferenceId, 'payment_reminder');
        
        // Format amount based on currency
        $currencySymbol = match($this->currency) {
            'USD' => '$',
            'IDR' => 'Rp',
            default => $this->currency,
        };
        $formattedAmount = $this->currency === 'USD' 
            ? $currencySymbol . ' ' . number_format($this->amount, 2, '.', ',')
            : $currencySymbol . '. ' . number_format($this->amount, 0, ',', '.');
        
        if ($tpl) {
            $conference = $this->conferenceId
                ? \App\Models\Conference::find($this->conferenceId)
                : \App\Models\Conference::where('is_active', true)->first();
            $vars = [
                'name'            => $this->userName,
                'conference_name' => $conference?->name ?? config('app.name'),
                'package_name'    => 'Pembayaran Prosiding',
                'invoice'         => $this->invoiceNumber,
                'invoice_number'  => $this->invoiceNumber,
                'amount'          => $formattedAmount,
                'payment_url'     => $this->paymentUrl,
                'dashboard_url'   => $this->paymentUrl,
            ];
            $subject = $tpl->renderSubject($vars);
            return $this
                ->subject($subject)
                ->view('emails.custom-template', [
                    'subject' => $subject,
                    'body'    => $tpl->render($vars),
                    'icon'    => $tpl->icon(),
                ]);
        }

        return $this->subject('⏰ Pengingat: Segera Upload Bukti Pembayaran — ' . config('app.name'))
                    ->view('emails.payment-reminder');
    }
}
