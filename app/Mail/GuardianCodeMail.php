<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Queue\SerializesModels;

class GuardianCodeMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */
    public function __construct(public User $user, public $guardian_code)
    {
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            from: new Address('tobiolanitori@example.com', 'Tobi Olanitori'),
            subject: 'Guardian Code Mail',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        // use markdown to use markdown syntax and view to use blade syntax
        return new Content(
            markdown: 'mail.guardian-code',
            with: [
                'name' => $this->user->first_name . ' '. $this->user->last_name,
                'guardian_code' => $this->guardian_code
            ]
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
