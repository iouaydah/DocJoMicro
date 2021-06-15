<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class TestEmail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $data;

    public function __construct($data)
    {
        $this->data = $data;
        
    }

    // Build an Email with an HTML and a Plain Text Copy with the specified message
    public function build()
    {
        $address = $this->data['from'];
        $subject = $this->data['subject'];
        $name = 'Doc Jo';
        
        return $this->view('emails.test')
                    ->text('emails.test_plain')
                    ->from($address, $name)
                    ->cc($address, $name)
                    ->bcc($address, $name)
                    ->replyTo($address, $name)
                    ->subject($subject)
                    ->with([ 'email_message' => $this->data['message'] ]);
    }
}