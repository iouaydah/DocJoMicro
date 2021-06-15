<?php

namespace App\Http\Controllers;

use App\Models\Emails;
use Illuminate\Http\Request;
use App\Mail\TestEmail;
use Illuminate\Support\Facades\Mail;

class EmailsController extends Controller
{
    /*
    * Json API Mailer Service
    */

    //POST /api/Emails: API to send emails and log them to a DB
    public function create(Request $request)
    {
        $data=['from' => $request->input('from'),
                'subject' => $request->input('subject'),
                'message' => $request->input('body'),
        ];
        
        try{
            Mail::to($request->input('to'))->send(new TestEmail($data));
        }
        catch(\Excpetion $e){
            return response()->json(['message' => $e], 500);
        }
        $Emails = Emails::create($request->all());
        return response()->json($Emails, 201);
    }

    // API to retreive all Emails from DB Log
    public function showAllEmails()
    {
        return response()->json(Emails::all());
    }

    public function showOneEmail($id)
    {
        return response()->json(Emails::find($id));
    }

    public function update($id, Request $request)
    {
        $Emails = Emails::findOrFail($id);
        $Emails->update($request->all());

        return response()->json($Emails, 200);
    }

    public function delete($id)
    {
        Emails::findOrFail($id)->delete();
        return response('Deleted Successfully', 200);
    }
}