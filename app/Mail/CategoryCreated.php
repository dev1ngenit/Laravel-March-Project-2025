<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class CategoryCreated extends Mailable
{
    
    use Queueable, SerializesModels;

    public $category;

    /**
     * Create a new message instance.
     *
     * @param Category $coupon
     * @return void
     */
    public function __construct($category)
    {
        $this->category = $category;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('New Category Created')
            ->view('emails.category_created');
    }

}
