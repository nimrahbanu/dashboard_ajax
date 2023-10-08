<?php

namespace App\Http\Controllers;
use App\Models\TempImage;
use Illuminate\Http\Request;

class TempImageController extends Controller
{
    //
public function upload(Request $request){
   
    $temp = new TempImage;
    $temp->name = 'temp vl';
    $temp->save();
    $image = $request->file('file');
    $destinationPath = './uploads/temp/';
    $extension = $image->getClientOriginalExtension();
    $newfilename = $temp->id.'.'.$extension;
    $image->move($destinationPath,$newfilename);
    $temp->name = $newfilename;
    $temp->save();

    return response()->json([
        'status' => 200,
        'id' => $temp->id,
        'name' => $newfilename
    ]);
}


    public function store(Request $request){
        if(!empty($request->image)){
            $image = $request->image;
            $ext = $image->getClientOriginalExtension();
            $tempImage = new TempImage();
            $tempImage->name = 'NULL';
            $tempImage->save();

            $imageName = $tempImage->id.'.'.$ext;
            $tempImage->name = $imageName;
            $tempImage->save();

            $image->move(public_path('uploads/temp/'), $imageName);

            return response()->json([
                'status' =>true,
                'image_id' => $tempImage->id,
                'name' => $imageName
            ]);
        }
    }
}
