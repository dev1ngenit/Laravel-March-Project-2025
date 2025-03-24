<?php
namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ProductCreated extends Mailable
{
    use Queueable, SerializesModels;

    public $product;

    /**
     * Create a new message instance.
     *
     * @param Brand $product
     * @return void
     */
    public function __construct($product)
    {
        $this->product = $product;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('New Product Created')
            ->view('emails.product_created');
    }
}
