<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class GenericNotificationMail extends Mailable
{
    use Queueable, SerializesModels;

    public string $subjectText;
    public string $bodyText;

    public function __construct(string $subjectText, string $bodyText)
    {
        $this->subjectText = $subjectText;
        $this->bodyText = $bodyText;
    }

    public function build()
    {
        return $this
            ->subject($this->subjectText)
            ->view('admin.emails.generic')
            ->with([
                'subjectText' => $this->subjectText,
                'content'     => $this->bodyText,
            ]);
    }
}
