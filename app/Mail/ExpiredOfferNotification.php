<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ExpiredOfferNotification extends Mailable
{
    use Queueable, SerializesModels;

    public $offer;

    public function __construct($offer)
    {
        $this->offer = $offer;
    }

    public function build()
    {
        return $this->subject('Offer Expired Notification')
                    ->view('emails.expired_offer')
                    ->with(['offer' => $this->offer]);
    }
}
