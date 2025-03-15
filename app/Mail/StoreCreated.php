<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class StoreCreated extends Mailable
{
    use Queueable, SerializesModels;

    public $store;

    /**
     * Create a new message instance.
     *
     * @param Store $store
     * @return void
     */
    public function __construct($store)
    {
        $this->store = $store;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('New Store Created')
            ->view('emails.store_created');
}
}
