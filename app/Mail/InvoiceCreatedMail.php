<?php

namespace App\Mail;

use App\Models\EmailTemplate;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class InvoiceCreatedMail extends Mailable
{
    use Queueable, SerializesModels;

    public $userName;
    public $paperTitle;
    public $invoiceNumber;
    public $amount;
    public $paymentUrl;
    public ?int $conferenceId;

    /**
     * Create a new message instance.
     */
    public function __construct($userName, $paperTitle, $invoiceNumber, $amount, $paymentUrl, ?int $conferenceId = null)
    {
        $this->userName = $userName;
        $this->paperTitle = $paperTitle;
        $this->invoiceNumber = $invoiceNumber;
        $this->amount = $amount;
        $this->paymentUrl = $paymentUrl;
        $this->conferenceId = $conferenceId;
    }

    /**
     * Build the message.
     */
    public function build()
    {
        $tpl = EmailTemplate::forConference($this->conferenceId, 'invoice_created');
        if ($tpl) {
            $conference = $this->conferenceId
                ? \App\Models\Conference::find($this->conferenceId)
                : \App\Models\Conference::where('is_active', true)->first();
            $vars = [
                'name'             => $this->userName,
                'conference_name'  => $conference?->name ?? config('app.name'),
                'paper_title'      => $this->paperTitle ?? '',
                'invoice'          => $this->invoiceNumber,
                'invoice_number'   => $this->invoiceNumber,
                'amount'           => number_format($this->amount, 0, ',', '.'),
                'due_date'         => '',
                'payment_url'      => $this->paymentUrl,
                'dashboard_url'    => $this->paymentUrl,
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

        return $this->subject('Tagihan Pembayaran - ' . config('app.name'))
                    ->view('emails.invoice-created');
    }
}
