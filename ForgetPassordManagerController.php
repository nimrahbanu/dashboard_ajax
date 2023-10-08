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
class ForgetPassordManagerController extends Controller
{
    //
    public function forgetPassword(){
        return view('forget-password');

    }

    public function forgetPasswordPost(Request $request){
    $request->validate([
        'email' => 'required|email|exists:users',
    ]);
    $token = Str::random(64);
    DB::table('password_reset_tokens')->insert([
        'email' => $request->email,
        'token' => $token,
        'created_at' => Carbon::now()
    ]);

    Mail::send('email.forget-password',['token'=>$token], function ($message) use ($request){
       $message->to($request->email);
       $message->subject('Reset Password'); 
    });
    return redirect()->to(route('forget.password'))->with('success', 'We have send an email to reset password.');

}

    public function resetPassword($token){
     return view('new-password',compact('token'));
    }

    public function resetPasswordPost(Request $request){
        $request->validate([
            'email' => 'required|email|exists:users',
            'password' => 'required|string|min:6|confirmed',
            'password_confirmation' => 'required',
        ]);
        $updatePassword = DB::table('password_reset_tokens')->where([
            "email" => $request->email,
            "token" => $request->token,
        ])->first();
    
        if(!$updatePassword){
            return redirect()->to(route('reset.password'))->with('error', 'invalid password');
        }
        User::where('email', $request->email)
        ->update(['password'=> Hash::make($request->password)]);
        DB::table('password_reset_tokens')
        ->where(["email"=> $request->email])->delete();
        return redirect()->to(route('login'))->with('success','password reset success');
      }


public function destroy($id){
 
}

}
