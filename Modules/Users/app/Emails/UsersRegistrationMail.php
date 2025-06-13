<?php

namespace Modules\Users\Emails;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class UsersRegistrationMail extends Mailable
{
    use Queueable, SerializesModels;

    public $subject;
    public mixed $url;
    public mixed $username;
    public mixed $name;
    public mixed $surname;
    public mixed $email;

    public function __construct($subject, $url, $username, $name, $surname, $email)
    {
        $this->subject = $subject;
        $this->url = $url;
        $this->username = $username;
        $this->name = $name;
        $this->surname = $surname;
        $this->email= $email;
    }
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: $this->subject,
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'Users::users.mail-registration',
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
