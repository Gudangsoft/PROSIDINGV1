<?php

namespace App\Mail;

use App\Models\EmailTemplate;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NewEventMail extends Mailable
{
    use Queueable, SerializesModels;

    public $userName;
    public $eventName;
    public $eventDate;
    public $eventUrl;
    public ?int $conferenceId;
    public ?string $conferenceVenue;

    /**
     * Create a new message instance.
     */
    public function __construct($userName, $eventName, $eventDate, $eventUrl, ?int $conferenceId = null, ?string $conferenceVenue = null)
    {
        $this->userName = $userName;
        $this->eventName = $eventName;
        $this->eventDate = $eventDate;
        $this->eventUrl = $eventUrl;
        $this->conferenceId = $conferenceId;
        $this->conferenceVenue = $conferenceVenue;
    }

    /**
     * Build the message.
     */
    public function build()
    {
        $tpl = EmailTemplate::forConference($this->conferenceId, 'new_event');
        if ($tpl) {
            $vars = [
                'conference_name'  => $this->eventName,
                'conference_date'  => $this->eventDate ?? '',
                'conference_venue' => $this->conferenceVenue ?? '',
                'register_url'     => $this->eventUrl,
            ];
            return $this
                ->subject($tpl->renderSubject($vars))
                ->html($tpl->render($vars));
        }

        return $this->subject('Kegiatan Baru: ' . $this->eventName)
                    ->view('emails.new-event');
    }
}
