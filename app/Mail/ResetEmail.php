<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ResetEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $data = [];

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($data = [
        'email' => '',
        'link' => ''
    ])
    {
        $this->data = $data;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        
        return $this->from(env('MAIL_FROM_ADDRESS'), 'Asfarco Group - Reset Password')
            ->subject('Asfarco Group - Reset Password')
            ->replyTo(env('MAIL_FROM_ADDRESS'))
            ->cc(env('MAIL_FROM_ADDRESS'))
            ->bcc(env('MAIL_FROM_ADDRESS'))
            ->view('mails.reset')->with(['data' => $this->data]);
    }
}
