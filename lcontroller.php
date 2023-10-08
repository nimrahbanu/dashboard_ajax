<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Http\Models\l;
use Validator;
use DB;
use Auth;
use Hash;
use App\Models\r;
use Illuminate\Support\Facades\Mail;
use App\Mail\FirstMail;
use App\Mail\SecondMal;

use Symfony\Component\Mailer\SentMessage;
use Symfony\Component\Mailer\Transport\AbstractTransport;
use Symfony\Component\Mime\MessageConverter;

class lcontroller extends Controller
{
    //
   
    public function index(){
        if(auth::check()){
            return redirect()->route('testhome');
        }
        return view('test.login');
    }
    public function save(Request $request){
        $request->validate([
            'email' =>'required|exists:register',
            'password' =>'required',
        ]);
        $credential = $request->only('email','password');
// send mail using FirstMail class

    //   Mail::to($request->email)->cc('nimrah271999@gmail.com')->send(new FirstMail('nimy'));
    // Mail::to($request->email)->send(new FirstMail());

    //end
    //send mail using message with attachment file
 
    // $data = array('name'=>"Virat Gandhi");
    // $email = $request->email;
    // Mail::send('mails.first-mail', $data, function($message) {
    //    $message->to('nimgori22@gmail.com', 'Tutorials Point')->subject
    //       ('Laravel Testing Mail with Attachment');
    //    $message->attach(public_path('uploads/1695280076_loadrer.gif'));
    //    $message->attach(public_path('uploads/2.jpg'));
    //    $message->from('nimgori22@gmail.com','Virat koli');
    // });
    //end


    $data = array('name'=>"Virat Gandhi");
    $email = $request->email;
   

    Mail::send('mails.first-mail', ['email' => $email], function ($message) use ($email) {
        $message->from($_ENV['MAIL_FROM_ADDRESS'], $_ENV['MAIL_FROM_NAME']);
        $message->to($email,  $_ENV['MAIL_FROM_NAME'])->subject('project details');
       $message->attach(public_path('uploads/2.jpg'));
    request()->session()->flash('success', 'Client Email Send Successfully !!');
       
     });           
    if(Auth::attempt(['email'=>request('email'), 'password' => request('password')])){
        return redirect()->route('testhome')->with('success',' Login Successfully');
    }
    return redirect()->route('llogin')->with('error', 'Login Invalid');
    }
}