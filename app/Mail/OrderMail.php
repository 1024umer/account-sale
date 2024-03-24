<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class OrderMail extends Mailable
{
    use Queueable, SerializesModels;

    public $channels;
    public $name;
    public $product_type;

    public $orderMode;

    /**
     * Create a new message instance.
     */
    public function __construct($channels, $name, $product_type, $orderMode)
    {
        $this->name = $name;
        $this->channels = $channels;
        $this->product_type = $product_type;
        $this->orderMode = $orderMode;

    }

    public function build()
    {
        return $this->subject('Order recived')
            ->markdown('mail.order_mail', [
                'name' => $this->name,
                'channels' => $this->channels,
                'product_type' => $this->product_type,
                'orderMode' => $this->orderMode,
            ]);
    }


    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Order recived',
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
