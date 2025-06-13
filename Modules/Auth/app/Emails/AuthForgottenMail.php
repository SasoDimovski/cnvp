<?php

namespace Modules\Auth\Emails;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class AuthForgottenMail extends Mailable
{
    use Queueable, SerializesModels;

    public mixed $url;
    public mixed $name;
    public mixed $surname;
    public mixed $email;
    /**
     * Create a new message instance.
     */
    public function __construct($url, $name, $surname, $email)
    {
        $this->url = $url;
        $this->name = $name;
        $this->surname = $surname;
        $this->email= $email;
    }
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: __('auth.AuthForgottenMail.email_subject'),
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
            view: 'Auth::auth.mail-forgotten',
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
