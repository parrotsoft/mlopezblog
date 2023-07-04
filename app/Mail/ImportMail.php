<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Queue\SerializesModels;

class ImportMail extends Mailable
{
    use Queueable;
    use SerializesModels;

    public function __construct(public string $text)
    {
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.import',
        );
    }
}
