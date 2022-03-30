<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class MailtrapSender extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($token)
    {
        $this->token = $token;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        // return $this->view('view.name');
        return $this->from('dipakchandore@gmail.com', 'Mailtrap')
            ->subject('Mailtrap Confirmation')
            ->markdown('mails.forget')
            ->with([
                'name' => 'New Mailtrap User',
                // 'link' => '/inboxes/',
                'link' => 'http://demo-api.com/reset/'.$this->token, 
                // 'token' => $this->token
            ]);
    }
}
