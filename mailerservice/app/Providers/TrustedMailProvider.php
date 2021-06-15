<?php

namespace App\Providers;

use Illuminate\Mail\MailServiceProvider;

class TrustedMailProvider extends MailServiceProvider
{

    function registerIlluminateMailer()
    {
        dd($this->app['config']);
        if ($this->app['config']['mail.driver'] == 'trusted') {
            $this->registerTrustedMailer();
        } else {
            parent::registerIlluminateMailer();
        }
    }

    function registerTrustedMailer()
    {
        $this->app['swift.mailer'] = $this->app->share(function ($app) {
            return new \Swift_Mailer(new TrustedTransport());
        });
    }

}
