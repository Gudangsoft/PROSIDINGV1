<?php

namespace App\Mail;

use App\Models\EmailTemplate;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PaymentVerifiedMail extends Mailable
{
    use Queueable, SerializesModels;

    public string $userName;
    public string $invoiceNumber;
    public int|float $amount;
    public string $currency;
    public string $paymentType; // 'paper' or 'participant'
    public ?string $paperTitle;
    public string $dashboardUrl;
    public string $loginUrl;
    public ?int $conferenceId;
    public ?string $waGroupLink;

    public function __construct(
        string $userName,
        string $invoiceNumber,
        int|float $amount,
        string $paymentType,
        ?string $paperTitle,
        string $dashboardUrl,
        ?int $conferenceId = null,
        ?string $waGroupLink = null,
        string $currency = 'IDR'
    ) {
        $this->userName     = $userName;
        $this->invoiceNumber = $invoiceNumber;
        $this->amount       = $amount;
        $this->currency     = $currency;
        $this->paymentType  = $paymentType;
        $this->paperTitle   = $paperTitle;
        $this->dashboardUrl = $dashboardUrl;
        $this->loginUrl     = route('login');
        $this->conferenceId = $conferenceId;
        $this->waGroupLink  = $waGroupLink;
    }

    public function build(): static
    {
        $tpl = EmailTemplate::forConference($this->conferenceId, 'payment_verified');
        
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
                'package_name'    => $this->paymentType === 'paper' ? ($this->paperTitle ?? 'Paper') : 'Registrasi Peserta',
                'invoice'         => $this->invoiceNumber,
                'invoice_number'  => $this->invoiceNumber,
                'amount'          => $formattedAmount,
                'dashboard_url'   => $this->dashboardUrl,
                'wa_group_link'   => $this->waGroupLink ?? '',
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

        return $this->subject('✅ Pembayaran Terverifikasi — ' . config('app.name'))
                    ->view('emails.payment-verified');
    }
}
