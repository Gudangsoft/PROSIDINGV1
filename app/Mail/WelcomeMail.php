<?php

namespace App\Mail;

use App\Models\EmailTemplate;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class WelcomeMail extends Mailable
{
    use Queueable, SerializesModels;

    public $userName;
    public $userRole;
    public $dashboardUrl;
    public ?int $conferenceId;

    /**
     * Create a new message instance.
     */
    public function __construct($userName, $userRole, $dashboardUrl, ?int $conferenceId = null)
    {
        $this->userName = $userName;
        $this->userRole = $userRole;
        $this->dashboardUrl = $dashboardUrl;
        $this->conferenceId = $conferenceId;
    }

    /**
     * Build the message.
     */
    public function build()
    {
        $tpl = EmailTemplate::forConference($this->conferenceId, 'welcome');
        if ($tpl) {
            $conference = $this->conferenceId
                ? \App\Models\Conference::find($this->conferenceId)
                : \App\Models\Conference::where('is_active', true)->first();
            $vars = [
                'name'            => $this->userName,
                'email'           => '',
                'conference_name' => $conference?->name ?? config('app.name'),
                'login_url'       => $this->dashboardUrl,
                'dashboard_url'   => $this->dashboardUrl,
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

        return $this->subject('Selamat Datang di ' . config('app.name'))
                    ->view('emails.welcome');
    }
}
