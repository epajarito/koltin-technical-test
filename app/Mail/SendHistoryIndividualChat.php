<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SendHistoryIndividualChat extends Mailable
{
    use Queueable, SerializesModels;

    public $conversation;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($conversation)
    {
        $this->conversation = $conversation;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.users.individual-chat')
            ->subject("Publicación: {$this->conversation->post->title}");
    }
}
