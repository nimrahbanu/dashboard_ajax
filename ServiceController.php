<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use App\Models\Service;
use Image;
use File;
use App\Models\TempImage;
class ServiceController extends Controller
{

public function index(){
}


public function create(){

    return view('product.create');
}


public function save(Request $request){
    $validator = Validator::make($request->all(), [
        'name' => 'required'
    ]);

    if($validator->passes()){
        $service = new Service;
        $service->name = $request->name;
        $service->description = $request->description;
        $service->save();

        if($request->image_id > 0){
            $tempImage = TempImage::where('id', $request->image_id)->first();
             $tempfilename =  $tempImage->name;
             $imageArray = explode('.', $tempfilename);
             $extension = end($imageArray);
             $newFileName = 'services-'.$service->id.'.'.$extension;
             $sourcePath = './uploads/temp/'.$tempfilename;
     
             $destinatonpath = './uploads/services/thumb/small/'.$newFileName;
             $img = Image::make($sourcePath);
             $img->fit(360,220);
             $img->save($destinatonpath);
             
             $destinatonpath = './uploads/services/thumb/large/'.$newFileName;
             $img = Image::make($sourcePath);
            $img->resize(1150, null, function($constraint){
                $constraint->aspectRatio();
            });
            $img->save($destinatonpath);

            $service->image = $newFileName;
            $service->save();

            File::delete($sourcePath);


        }
            $request->session()->flash('success','Services Created Successfully');
            return response()->json([
                'status'=>200,
                'message' => 'Service Created Successfully'
            ]);
    }else{

        return response()->json([
            'status' => 0,
            'error' => $validator->errors()
        ]);
    }
}

public function list(Request $request){
    $services = Service::orderBy('created_at','DESC');
    if(!empty($request->keyword)){
      $services = $services->where('name','like', '%'.$request->keyword.'%')->orWhere('created_at','like', '%'.$request->keyword.'%')->orWhere('description','like', '%'.$request->keyword.'%');
    }
    $services = $services->paginate(4);
    $data['services'] = $services;
    return view('product.list', $data);
}
public function edit($id, Request $request){
    $services = Service::where('id',$id)->first();
    if(empty($services)){
        $request->session()->flash('error','Record not found');
        return redirect()->route('service.list');
    }
    $data['services'] = $services;
    return view('product.edit', $data);

}


public function update($id, Request $request){
    $validator = Validator::make($request->all(), [
        'name' => 'required'
    ]);
    if($validator->passes()){
        $service =  Service::find($id);
        if(empty($service)){
            $request->session()->flash('error'. 'Record Not');
            return response()->json([
                'status'=>0,
            ]);
        }
     if(!empty( $service->image_id)){
        $oldImageName = $service->image_id;

     }else{
        $oldImageName = '';

     }
        $service->name = $request->name;
        $service->description = $request->description;
        $service->save();

        if($request->image_id > 0){
            $tempImage = TempImage::where('id', $request->image_id)->first();
             $tempfilename =  $tempImage->name;
             $imageArray = explode('.', $tempfilename);
             $extension = end($imageArray);
             $newFileName = 'services-'.strtotime('now').'-'.$service->id.'.'.$extension;
             $sourcePath = './uploads/temp/'.$tempfilename;
                //generate small image
                $destinatonpath = './uploads/services/thumb/small/'.$newFileName;
                $img = Image::make($sourcePath);
                $img->fit(360,220);
                $img->save($destinatonpath);
                //delete old image
                $sourcePath = './uploads/services/thumb/small/'.$oldImageName;
                File::delete($sourcePath);
                 //generate large image
             
                //  $destinatonpath = './uploads/services/thumb/large/'.$newFileName;
                //  $img = Image::make($sourcePath);
                // $img->resize(1150, null, function($constraint){
                //     $constraint->aspectRatio();
                // });
            
                //    $img->save($destinatonpath);
                
              //delete old image
              $sourcePath = './uploads/services/thumb/large/'.$oldImageName;
              File::delete($sourcePath);

                $service->image = $newFileName;
                $service->save();

                File::delete($sourcePath);
           

        }
        $request->session()->flash('success','Services Created Successfully');
        return response()->json([
            'status'=>200,
            'message' => 'Service Updated Successfully'
        ]);
        }else{

        return response()->json([
            'status' => 0,
            'error' => $validator->errors()
        ]);
    }

}

public function destroy($id, Request $request){
$service = Service::find($id);
$service->delete();
$request->session()->flash('success','Services Deleted Successfully');

return redirect()->back();
}
}
