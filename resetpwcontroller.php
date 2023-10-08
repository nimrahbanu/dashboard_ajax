<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use  Validator;
use App\Models\User;
use Session;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Hash;

class resetpwcontroller extends Controller
{
    //
    public function index(){
        return view('test.resetemailform');
    }
    public function emailpw(Request $request){
     $request->validate([
        'email' => 'required',

     ]);
     $token = Str::random(64);
     $data = DB::table('password_reset_tokens')->insert([
    'email' => $request->email,
    'token' => $token,
]);
    
    Mail::send('test.emailsend',['token'=>$token], function ($message) use ($request){
        $message->to($request->email);
        $message->subject('Reset Password'); 
     });
     return redirect()->back()->with('success', 'We have send an email to reset password.');
    }
 public function pwresetview(){
    return view('test.password_confirm');
 }   
 public function pwresetpost(Request $request){
    $request->validate([
        'email'=> 'required',
        'password'=> 'required|confirmed',
        'password_confirmation'=> 'required',
    ]);
 $updatePassword  =  DB::table('password_reset_tokens')->where('email', $request->email)->first();
//  if(!empty($updatePassword)){
//     return redirect()->to(route('test-forget-password'))->with('error', 'invalid password');
//  }
 $password = Hash::make($request->password);
  DB::table('register')->where('email',$request->email)->update(['password'=> $password]);
 DB::table('password_reset_tokens')->where(['email'=>$request->email])->delete();

 return redirect()->to(route('llogin'))->with('success','password reset success');

 }
}
