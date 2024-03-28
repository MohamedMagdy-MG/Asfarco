<?php

namespace App\Mail\frontend;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class activeAccount extends Mailable
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
        'otp' => ''
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
        return $this->from(env('MAIL_FROM_ADDRESS'), 'Asfarco Group - activate your account ?')
            ->subject('Asfarco Group - activate your account ?')
            ->replyTo(env('MAIL_FROM_ADDRESS'))
            ->cc(env('MAIL_FROM_ADDRESS'))
            ->bcc(env('MAIL_FROM_ADDRESS'))
            ->view('mails.frontend.verify-otp')->with(['data' => $this->data]);
    }
}
