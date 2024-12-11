<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Http\Controllers\Controller;
use Intervention\Image\Laravel\Facades\Image;

class AdminController extends Controller
{
    public function index()
    {
        return view('admin.index');
    }

    public function brands(){
        $brands = Brand::orderBy('id','Desc')->paginate(10);
        return view('admin.brands',compact('brands'));
    }

    public function add_brand(){
        return view('admin.brand-add');
    }

    public function brand_store(Request $request){
        $request->validate([
            'name'=>'required',
            'slug'=>'required|unique:brands,slug',
            'image'=>'mimes:png,jpg,jpeg,svg|max:2048'
        ]);

        $brand = new Brand();
        $brand->name = $request->name;
        $brand->slug = Str::slug($request->name);
        $image = $request->file('image');
        $file_extension = $request->file('image')->extension();
        $file_name = Carbon::now()->timestamp.'.'.$file_extension;
        $this->GenerateBrandThumbnailsImage($image,$file_name);
        $brand->image = $file_name;
        $brand->save();

        return redirect()->route('admin.brands')->with('status','Brand has been addeed successfully!');
    }

    public function brand_edit($id){
        $brand = Brand::find($id);
        return view('admin.brand-edit',compact('brand'));
    }

    public function brand_update(Request $request){
        $request->validate([
            'name'=>'required',
            'slug'=>'required|unique:brands,slug,'.$request->id,
            'image'=>'mimes:png,jpg,jpeg,svg|max:2048'
        ]);

        $brand = Brand::find($request->id);
        $brand->name = $request->name;
        $brand->slug = Str::slug($request->name);
        if($request->hasFile('image')){
            if(File::exists(public_path('uploads/brands').'/'.$brand->image)){
                File::delete(public_path('uploads/brands').'/'.$brand->image);
            }
            $image = $request->file('image');
            $file_extension = $request->file('image')->extension();
            $file_name = Carbon::now()->timestamp.'.'.$file_extension;
            $this->GenerateBrandThumbnailsImage($image,$file_name);
            $brand->image = $file_name;
        }
        
        $brand->save();
        return redirect()->route('admin.brands')->with('status','Brand has been updated successfully!');
    }

    // to save in the public directory
    public function GenerateBrandThumbnailsImage($image, $imageName){
        $destinationPath = public_path('uploads/brands');
        $img = Image::read($image->path()); //add "intervention/image-laravel": "^1.2", in composer.json then composer install and composer update
        $img->cover(124,124,"top"); //height, width, position
        $img->resize(124,124,function($constraint){
            $constraint->aspectRatio();
        })->save($destinationPath.'/'.$imageName);
    }

    publiC function brand_delete($id){
        $brand = Brand::find($id);
        if(File::exists(public_path('uploads/brands').'/'.$brand->image)){
            File::delete(public_path('uploads/brands').'/'.$brand->image);
        }
        $brand->delete();
        return redirect()->route('admin.brands')->with('status','Brand has been deleted successfully!');
    }
}
