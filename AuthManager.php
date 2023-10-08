<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Session;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
class AuthManager extends Controller
{
    //
   public function login(){
    if(auth::check()){
        return redirect()->route('home');
    }
        return view('login');
   }


   public function register(){
    if(auth::check()){
        return redirect()->route('home');
    }  return view('registration');
   }


   public function loginPost(Request $request){
        $request->validate([
            'email' => 'required',
            'password' => 'required'
        ]);

        $credentials = $request->only('email', 'password');
        if(Auth::attempt(['email' => request('email'), 'password' => request('password')])){
            return redirect()->intended(route('home'))->with('succes', 'Login Details Are Valid');;
        }
        return redirect(route('login'))->with('error', 'Login Details Are Not Valid');
    
   }
   public function registrationPost(Request $request){
    $request->validate([
        'name'=>'required',
        'email'=>'required|email|unique:users',
        'password'=>'required',
    ]);
    $data['name'] = $request->name;
    $data['email'] = $request->email;
    $data['password'] = Hash::make($request->password);
    $user = User::create($data);
    if(!$user){
        return redirect(route('register'))->with('error','Registeration Failed, try again.');
    }
    return redirect(route('login'))->with('success','Registeration Success, Login to access the app');
    
   }
   public function logout(){
    Session::flush();
    Auth::logout();
    return redirect(route('login'));
   }
}
