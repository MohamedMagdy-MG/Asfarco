<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class InvitationsEmail extends Mailable
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
        
        return $this->from($address =  env('MAIL_FROM_ADDRESS'), $name =  'no-reply')
            ->subject('Asfarco Group - Invitation')
            ->replyTo(env('MAIL_FROM_ADDRESS'))
            ->cc(env('MAIL_FROM_ADDRESS'))
            ->bcc(env('MAIL_FROM_ADDRESS'))
            ->view('mails.invitations')->with(['data' => $this->data]);
    }
}
