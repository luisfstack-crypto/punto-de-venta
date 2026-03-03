<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class AdminNewUserNotification extends Mailable
{
    use Queueable, SerializesModels;

    public $newUser;

    public function __construct($newUser)
    {
        $this->newUser = $newUser;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: '[' . config('app.name') . '] Nueva solicitud de acceso: ' . $this->newUser->name,
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.admin_new_user',
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
