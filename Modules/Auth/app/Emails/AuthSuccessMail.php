<?php

namespace Modules\Auth\Emails;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class AuthSuccessMail extends Mailable
{
    use Queueable, SerializesModels;

    public mixed $hash;
    public mixed $name;
    public mixed $surname;
    public mixed $email;
    /**
     * Create a new message instance.
     */
    public function __construct($hash, $name, $surname,$email)
    {
        $this->hash = $hash;
        $this->name = $name;
        $this->surname = $surname;
        $this->email= $email;
    }
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: __('auth.AuthSuccessMail.email_subject'),
        );
    }
    /**
     * Get the message content definition.
     *
     * @return \Illuminate\Mail\Mailables\Content
     */
    public function content(): Content
    {
        return new Content(
            view: 'Auth::auth.mail-success',
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array
     */
    public function attachments(): array
    {
        return [];
    }
}
