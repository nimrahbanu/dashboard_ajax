<?php 

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use Image;
use Illuminate\Support\Facades\Storage;

use Validator;
use App\Models\TempImage;
use App\Models\Temporary;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = Category::paginate(5);;
    return view('ajax_form.index', compact('categories'));
    }

    public function fetchCategory(){
        $categories = Category::all();;
        return response()->json([
            'categories'=>$categories
        ]);
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('ajax_form.index');
    }

    /**
     * Store a newly created resource in storage.
     */
    

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'cat_name' => 'required',
            'cat_description' => 'required',
        ]);
        $temp_file = Temporary::where('folder', $request->cat_image)->first();
        if($validator->fails()){
              return response()->json([
                'status'=>400,
                'errors'=>$validator->messages(),
            ]);
        }else{
                Storage::copy('post/temp/'. $temp_file, 
                'posts/'.$temp_file);
   
                $Category = new Category;
                $Category->cat_name = $request->cat_name;
                $Category->cat_description = $request->cat_description;
                $Category->cat_image =  $temp_file;
               
           
                $Category->save();
    
                return response()->json([
                    'status' => 200,
                    'message' => 'Category Created Successfully'
    
                ]);
             
        }
        
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit( $id)
    {
        $categories = Category::FindOrFail($id);
        return response()->json([
            'status'=> 200,
            'categories'=> $categories
        ]);
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request,  $id)
    {
        $validator = Validator::make($request->all(),[
            'cat_name' => 'required',
            'cat_description' => 'required',
        ]);
        if($validator->fails()){
            return response()->json([
                'status'=>400,
                'errors'=>$validator->messages(),
            ]);
        }else{
            $Category =  Category::FindOrFail($id);
            if($Category){
                $Category->cat_name = $request->input('cat_name');
                $Category->cat_description = $request->input('cat_description');
                $Category->cat_image = $request->input('cat_image');
                $Category->update();
            }else{
                return response()->json([
                    'status'=>404,
                    'message'=>'Category not found',
                ]);
            }
        return response()->json([
            'status'=>200,
            'message'=>'Category Updated Successfully',
        ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy( $id)
    {
        $categories = Category::FindOrFail($id);
        if($categories){
            $categories->delete();
            return response()->json([
                'status'=>200,
                'message'=>'Category Deleted Successfully',
            ]);
        }else{
            return response()->json([
                'status'=>404,
                'message'=>'Category Not Deleted Successfully',
            ]);
        }

    }
   
    public function tempUpload(request $request){
        if($request->has('cat_image')){
            $image  = $request->file('cat_image');
            $file_name = $image->getClientOriginalName();
            $folder = uniqid('post', true);
            $image->storeAs('post/temp/'.$folder, $file_name);
            Temporary::create([
                'folder'=>$folder,
                'file'=>$file_name
            ]);
        return redirect()->back()->with($folder);
    }
    return '';
    }
    
    public function tempDelete(){
        
    }
}

