<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class Activation extends Mailable
{
    use Queueable, SerializesModels;
    public $user,$token;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(\Cartalyst\Sentinel\Users\EloquentUser $user, \Cartalyst\Sentinel\Activations\EloquentActivation $token)
    {
        $this->user = $user;
        $this->token = $token->code;

    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.activation');
    }
}
