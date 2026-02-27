<?php

namespace App\Mail;

use App\Models\EmailTemplate;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class CustomTemplateMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        protected EmailTemplate $tpl,
        protected array $vars = []
    ) {}

    public function build(): static
    {
        $renderedSubject = $this->tpl->renderSubject($this->vars);
        $renderedBody    = $this->tpl->render($this->vars);

        return $this
            ->subject($renderedSubject)
            ->view('emails.custom-template', [
                'subject' => $renderedSubject,
                'body'    => $renderedBody,
                'icon'    => $this->tpl->icon(),
            ]);
    }
}
