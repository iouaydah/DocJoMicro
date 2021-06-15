<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Mail\TestEmail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Mail;
use Exception;

class DocJoEmailController extends Controller
{
    /**
     * Customer self-service controller.
     *
     */
    public $MailerURL;
    public function __construct()
    {
        $this->MailerURL='http://localhost:8000/api/Emails';
    }

    // sending sample email password reset (/resetp)
    public function sendpassreset(){
        
        //calling service Emails with post values
        try{
            $client= new Client();
            $client->postAsync($this->MailerURL,[
                'form_params' => [
                    'from'=>'service@service.test',
                    'to'=>'ismazei@hotmail.com',
                    'subject'=>'Password Forgotten',
                    'body'=>'You can follow this link to reset your Password',
                    ]
                ]);
        }
        catch(\Exception $e){
            return($e->getMessage());
        }
        return response()->json("Sent Successfully",201);
        //return $response;
    }

    // function sending sample email New Customer testing multiple receipients
    public function sendnewcust(){
        //this should register a new user and then sends an e-mail

        //$recipients=collect(['test@test.com','ismazei@hotmail.com','myemail2004@gmail.com']);
        //foreach($recipients as $recipient){}
        //calling service Emails is returning a Timeout Exception
        $response = Http::post($this->MailerURL, [
            'from'=>'service@service.test',
            'to'=>'ismailo@gmail.com',
            'subject'=>'New Customer Registered',
            'body'=>'New Customer has been registered. You are assigned to contact him',
        ]);
        
        // mailer service down
        if($response->status()!=201){
            dd($response);
            $error='mailer service down';
            return $error;
        }
        
        return response()->json($response);
        
    }





    // function sending markdown email 
    //--TODO-- $emailobject is giving an error
    public function markdownsample(){

        $data = ['message' => 'This is a message for our markdown test'];
        $emailobject= new MarkDownEmail($data);
        Mail::to('ismazei@hotmail.com')->send($emailobject);
    }

    /* sending through queue
    public function sendwithq(){

        $data = ['message' => 'This test passed by a queue'];

        Mail::to('ismazei@hotmail.com')->queue(new TestEmail($data));
    }
    */
    
    
}