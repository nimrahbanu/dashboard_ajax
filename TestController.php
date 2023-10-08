<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TestController extends Controller
{
    //
    public function email(Request $request)
    {     
        $request->validate([
            'prospect_id' => 'required', 
            'work_name_id' => 'required',
            'area' => 'required',
            'measurement_id' => 'required',
            
           ]);
        $measurements = Measurement::where('id',$request->measurement_id)->get();
        $work_names = WorkName::where('id',$request->name_id)->get();
        $rates = Rate::where('deleted_date', NULL)->where('name_id', $request->work_name_id)->with('measurement_name_info')->get();
        $packages = Package::where('deleted_date', NULL)->where('work_name_id', $request->work_name_id)->with('work_name_info')->with('rate_info')->get();
        $prospects = Prospect::where('id',$request->prospect_id)->with('state_info')->with('country_info')->first();
           
            $work_name_id  = $request->work_name_id;
            $Plannig_package_name  = $request->Plannig_package_name;
            $name = $prospects->name;
            $state_id = $prospects->state_info['state'];
            $country_id = $prospects->country_info['country'];
            $email_id = $prospects->email_id;
            $prospect_id = $prospects->id;
            $area = $request->area;
            $deadline = $request->deadline;
            //    print_r($Plannig_package_name);
            foreach($packages as $package){
                $pcg_rate =  json_decode($package->rate_id); 
                foreach($rates as $key=>$rate){
                if($area >= $rate['value'] ){
                             $amount = $area * $rate['price'];
                        }else{  
                             $amount = $area * $rate['price'];
                        }
                    }
                }    
  
        $pdf = PDF::loadview('pages.generateQoutation.genQuotationformat', compact('name', 'state_id', 'country_id', 'email_id',
        'work_name_id', 'packages', 'area', 'amount', 'prospects','measurements', 'rates', 'deadline', 'Plannig_package_name'))->setOptions(['defaultFont' => 'sans-serif']);
      $output = $pdf->output(); 
        foreach($packages as $package){
                $file_name = str_replace( " " , "-", $prospects->id ).'-'.$package->Plannig_package_name.'.pdf';
            }
        \Storage::disk('local')->put('/project/'.$file_name, $output);
        if(!empty($request->email)){
        $storagePath  = \Storage::disk('local')->path('project/'.$file_name);
           Mail::send('emails.project', ['user' => $prospects, 'path' => $storagePath], function ($mail) use ($prospects, $storagePath) {
                $mail->from($_ENV['MAIL_FROM_ADDRESS'], $_ENV['MAIL_FROM_NAME']);
                $mail->to($prospects->email_id, $prospects->name)->subject('project details');
                $mail->attach($storagePath);
                request()->session()->flash('success', 'Client Email Send Successfully !!');
                // print_r('<pre>');
                // print_r($a);
                // die();    
             });           
        }
    if($request->download_pdf){
        request()->session()->flash('success', 'Client Pdf Downloaded Successfully !!');
            return $pdf->download($file_name);

    }else{
        request()->session()->flash('success', 'Client Data Send Successfully !!');
        return redirect()->back();

    }
}   
   
    public function getPackageName(Request $request){
        $package_name = Package::where('work_name_id', $request->id)->get()->toArray();
        $rates = Rate::where('name_id', $request->id)->with('measurement_name_info')->get()->toArray();
        return json_encode($package_name);
        return json_encode($rates);
      
    }  
}
