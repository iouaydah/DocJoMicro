<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class MarkDownEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function build()
    {
        $address = 'ismail.ouaydah@gmail.com';
        $subject = 'Markdown email!';
        $name = 'Doc Jo';

        return $this->from('example@example.com')
                    ->markdown('emails.markdown', [
                            'url' => 'google.com',
                     ]);
    }
}