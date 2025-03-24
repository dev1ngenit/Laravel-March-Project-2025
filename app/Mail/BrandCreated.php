<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class BrandCreated extends Mailable
{
    use Queueable, SerializesModels;

    public $brand;

    /**
     * Create a new message instance.
     *
     * @param Brand $brand
     * @return void
     */
    public function __construct($brand)
    {
        $this->brand = $brand;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('New Brand Created')
            ->view('emails.brand_created');
    }
}
