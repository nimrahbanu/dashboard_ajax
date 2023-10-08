<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Models\l;
use Validator;
use DB;
use Session;
use Hash;
use Auth;
use App\Models\r;
class rcontroller extends Controller
{
    //
    public function testhome(){
        return view('test.testhome');
    }
    public function testlogout(){
        Session::flush();
        return redirect()->route('llogin');
    }
    
    public function index(){
        if(auth::check()){
            return redirect()->route('testhome');
        }
        return view('test.register');
    }
    public function save(Request $request){
       $request->validate([
        'email' => 'required|email|unique:register',
        'name' => 'required',
        'password' => 'required',
       ]);
      

       $data['name'] = $request->name;
       $data['email'] = $request->email;
       $data['password'] = Hash::make($request->password);
       $status = r::create($data);
       if($status){
        return redirect()->route('llogin')->with('success','Registration Successfully Complete!!');
       }else{
        return redirect()->route('rregister')->with('error','Registration Not Complete!!');

       }
    }
}
