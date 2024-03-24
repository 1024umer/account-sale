<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class TicketReplyMail extends Mailable
{
    use Queueable, SerializesModels;

    public $subject;
    public $name;
    public $message;
    /**
     * Create a new message instance.
     */
    public function __construct($name, $subject, $message)
    {
        $this->message = $message;
        $this->subject  = $subject;
        $this->name = $name;
    }

    public function build()
    {
        return $this->subject('Ticket reply email')
            ->markdown('mail.ticket_reply', [
                'name' => $this->name,
                'subject' => $this->subject,
                'message' => $this->message,
            ]);
    }


    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Ticket Reply Mail',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'view.name',
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
