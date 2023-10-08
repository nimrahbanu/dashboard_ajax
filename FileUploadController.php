<?php

namespace App\Http\Controllers;
use ImageOptimizer;
use Illuminate\Http\Request;
use Validator;
use Image;
use App\Models\FileUpload;
use File;
class FileUploadController extends Controller
{
    public function index(){
        return view('file.file');
    }

public function save(Request $request){
    $request->validate([
        'file'=>'required'
    ]);
 $file =    $request->file('file');
 $filename = $file->getClientOriginalName();
 $filetype = $file->getClientOriginalExtension();
 $filepath = $file->getRealPath();
$fileSize = $file->getSize();
$fileMimeType = $file->getMimeType();
$path = 'uploads/' . $filename;

print_r('file=> '.$file.'<br>');
print_r('filename=> '.$filename.'<br>');
print_r('filetype=> '.$filetype.'<br>');
print_r('filepath=> '.$filepath.'<br>');
print_r('fileSize=> '.$fileSize.'<br>');
print_r('fileMimeType=> '.$fileMimeType.'<br>');
$destination = "uploads";

//image resize
// $image_name = date('d-m-y').'-'. '1.jpg';
// $path = public_path('uploads/')."/".$image_name;
// Image::make($image->getRealPath())->resize(100,100)->save($path);
// $image_name = time().'_'.$file->getClientOriginalName();
//endimage resize
$image_name = time().'_'.$file->getClientOriginalName();
$path = public_path('uploads/') . "/" . $image_name;

$compressimage = Image::make($file->getRealPath())->encode('jpeg', 90)->save($path);
$resizeimage = Image::make($file->getRealPath())->resize(150, 150)->save($path);

$status = new FileUpload;
$status->file = $filename;
$status->save();
if($file->move($destination,$filename) || $resizeimage || $compressimage ){
    echo "image uploaded successfully";
    return redirect()->back()->with('success', 'Image Uploaded Successfully');
}else{
    return redirect()->back()->with('error', 'Image Not Uploaded');
    }
}   
}  

