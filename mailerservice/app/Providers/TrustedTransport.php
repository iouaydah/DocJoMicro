<?php

//namespace App\Mail\Transport;

namespace App\Providers;

use Illuminate\Mail\Transport\Transport;
use Illuminate\Support\Facades\Log;
use Swift_Mime_Message;
use App\Models\Emails;

class TrustedTransport extends Transport
{

    public function __construct()
    {
    }


    public function send(Swift_Mime_Message $message, &$failedRecipients = null)
    {
        dd($message);
        Emails::create([
            'body'    => $message->getBody(),
            'to'      => implode(',', array_keys($message->getTo())),
            'subject' => $message->getSubject()
        ]);
    }

}