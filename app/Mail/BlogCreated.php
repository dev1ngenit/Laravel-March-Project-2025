<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class BlogCreated extends Mailable
{
    use Queueable, SerializesModels;

    public $blog;

    /**
     * Create a new message instance.
     *
     * @param Brand $blog
     * @return void
     */
    public function __construct($blog)
    {
        $this->blog = $blog;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('New Blog Created')
            ->view('emails.blog_created');
    }
}
