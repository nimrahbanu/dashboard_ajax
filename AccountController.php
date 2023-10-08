<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use  Validator;
use App\Models\Data;

class AccountController extends Controller
{
    //
    public function index(){
      $countries =   DB::table('countries')->orderby('name','ASC')->get();
      $data['countries'] = $countries;
        return view('users.create', $data);

    }
    public function create(){
            return view('users.create');
    }

    public function fetchstates($country_id = null){
        $states = DB::table('states')->where('country_id', $country_id)->get();
        return response()->json([
            'status' => 1,
            'states' => $states

        ]);
    }
    public function fetchcities($state_id = null){
        $cities = DB::table('cities')->where('state_id', $state_id)->get();
        return response()->json([
            'status' => 1,
            'cities' => $cities
        ]);
    }
    public function save(Request $request){
     
      $validator = Validator::make($request->all(),[
            'name' => 'required',
            'email' => 'required|email'
        ]);
        if($validator->passes()){

            $user = new Data;
            print_r(  $user );
            $user->name = $request->name;
            $user->email = $request->email;
            $user->country = $request->country;
            $user->state = $request->state;
            $user->city = $request->city;
            $user->save();

            $request->session()->flash('success', 'User Added Succesfully.');
            return response()->json([
                'status' => 1
            ]);

        }else{
      
        return response()->json([
            'status' => 0,
            'errors' => $validator->errors()
        ]);
        }
    }

    public function list(){
        $users = DB::table('datas')->get();
        $data['users'] = $users;
        return view('users.list', $data);
    }

    public function edit($id){
      $users =  DB::table('datas')->where('id', $id)->first();
      $countries =   DB::table('countries')->orderby('name','ASC')->get();
      $states =   DB::table('states')->where('country_id', $users->country)->get();
      $cities =   DB::table('cities')->where('state_id', $users->state)->get();
      $data['users'] = $users;
      $data['countries'] = $countries;
      $data['states'] = $states;
      $data['cities'] = $cities;
         return view('users.edit', $data);
    }

    public function update($id, Request $request){
     
        $user = Data::find($id);
        if($user == null){
            $request->session()->flash('error','Either User deleted or not found');
            return response()->json([
                'status' => '400'
            ]);
        }
        $validator = Validator::make($request->all(),[
              'name' => 'required',
              'email' => 'required|email'
          ]);
          if($validator->passes()){
  
              $user->name = $request->name;
              $user->email = $request->email;
              $user->country = $request->country;
              $user->state = $request->state;
              $user->city = $request->city;
              $user->save();
  
              $request->session()->flash('success', 'User Added Succesfully.');
              return response()->json([
                  'status' => 1
              ]);
  
          }else{
        
          return response()->json([
              'status' => 0,
              'errors' => $validator->errors()
          ]);
          }
      }


public function destroy($id){
    $users = Data::destroy($id);
    if($users){
        return redirect()->back();
    }
}

}
