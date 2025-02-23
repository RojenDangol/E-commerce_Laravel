<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\About;
use App\Models\Brand;
use App\Models\Order;
use App\Models\Slide;
use App\Models\Coupon;
use App\Models\Contact;
use App\Models\Product;
use App\Models\Category;
use App\Models\OrderItem;
use App\Models\ProductMeta;
use App\Models\Transaction;
use Illuminate\Support\Str;
use App\Models\RepeaterItem;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Models\ContactInformation;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Intervention\Image\Laravel\Facades\Image;

class AdminController extends Controller
{
    public function index(){
        $orders = Order::orderBy('created_at','DESC')->get()->take(10);
        $dashboardDatas = DB::select("Select sum(total) As TotalAmount,
                                        sum(if(status='ordered', total, 0)) As TotalOrderedAmount,
                                        sum(if(status='delivered', total, 0)) As TotalDeliveredAmount,
                                        sum(if(status='canceled', total, 0)) As TotalCanceledAmount,
                                        Count(*) As Total,
                                        sum(if(status='ordered', 1, 0)) As TotalOrdered,
                                        sum(if(status='delivered', 1, 0)) As TotalDelivered,
                                        sum(if(status='canceled', 1, 0)) As TotalCanceled
                                        From Orders
                                        ");
        $monthlyDatas = DB::select("SELECT M.id AS MonthNo, M.name AS MonthName, IFNULL(D.TotalAmount, 0) AS TotalAmount, 
                                    IFNULL(D.TotalOrderedAmount, 0) AS TotalOrderedAmount, 
                                    IFNULL(D.TotalDeliveredAmount, 0) AS TotalDeliveredAmount, 
                                    IFNULL(D.TotalCanceledAmount, 0) AS TotalCanceledAmount 
                                    FROM month_names M 
                                    LEFT JOIN (
                                        SELECT DATE_FORMAT(created_at, '%b') AS MonthName, 
                                        MONTH(created_at) AS MonthNo, 
                                        SUM(total) AS TotalAmount, 
                                        SUM(IF(status = 'ordered', total, 0)) AS TotalOrderedAmount, 
                                        SUM(IF(status = 'delivered', total, 0)) AS TotalDeliveredAmount, 
                                        SUM(IF(status = 'canceled', total, 0)) AS TotalCanceledAmount 
                                        FROM Orders 
                                        WHERE YEAR(created_at) = YEAR(NOW()) 
                                        GROUP BY YEAR(created_at), MONTH(created_at), DATE_FORMAT(created_at, '%b')
                                    ) D ON D.MonthNo = M.id 
                                    ORDER BY M.id");
        $AmountM = implode(',', collect($monthlyDatas)->pluck('TotalAmount')->toArray());
        $OrderedAmountM = implode(',', collect($monthlyDatas)->pluck('TotalOrderedAmount')->toArray());
        $DeliveredAmountM = implode(',', collect($monthlyDatas)->pluck('TotalDeliveredAmount')->toArray());
        $CanceledAmountM = implode(',', collect($monthlyDatas)->pluck('TotalCanceledAmount')->toArray());

        $TotalAmount = collect($monthlyDatas)->sum('TotalAmount');
        $TotalOrderedAmount = collect($monthlyDatas)->sum('TotalOrderedAmount');
        $TotalDeliveredAmount = collect($monthlyDatas)->sum('TotalDeliveredAmount');
        $TotalCanceledAmount = collect($monthlyDatas)->sum('TotalCanceledAmount');

        return view('admin.index',compact('orders','dashboardDatas','AmountM','OrderedAmountM','DeliveredAmountM','CanceledAmountM','TotalAmount','TotalOrderedAmount','TotalDeliveredAmount','TotalCanceledAmount'));
    }

    public function brands(Request $request){
        $brands = Brand::orderBy('id','Desc')->paginate(10);
        $results = null;
        return view('admin.brands',compact('brands','results'));
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

    // Category controller part

    public function categories(Request $request){
        $categories = Category::orderBy('id','DESC')->paginate(10);
        $results = null;
        return view('admin.categories',compact('categories','results'));
    }

    public function category_add(){
        return view('admin.category-add');
    }

    public function category_store(Request $request){
        $request->validate([
            'name'=>'required',
            'slug'=>'required|unique:categories,slug,'.$request->id,
            'image'=>'mimes:png,jpg,jpeg,svg|max:2048'
        ]);

        $category = new Category();
        $category->name = $request->name;
        $category->slug = Str::slug($request->name);
        $image = $request->file('image');
        $file_extension = $request->file('image')->extension();
        $file_name = Carbon::now()->timestamp.'.'.$file_extension;
        $this->GenerateCategoryThumbnailsImage($image,$file_name);
        $category->image = $file_name;
        $category->save();

        return redirect()->route('admin.categories')->with('status','Category has been addeed successfully!');
    }

    public function GenerateCategoryThumbnailsImage($image, $imageName){
        $destinationPath = public_path('uploads/categories');
        $img = Image::read($image->path()); 
        $img->cover(124,124,"top"); //height, width, position
        $img->resize(124,124,function($constraint){
            $constraint->aspectRatio();
        })->save($destinationPath.'/'.$imageName);
    }
    
    public function category_edit($id){
        $category = Category::find($id);
        return view('admin.category-edit',compact('category'));
    }

    public function category_update(Request $request){
        $request->validate([
            'name'=>'required',
            'slug'=>'required|unique:categories,slug,'.$request->id,
            'image'=>'mimes:png,jpg,jpeg,svg|max:2048'
        ]);

        $category = Category::find($request->id);
        $category->name = $request->name;
        $category->slug = Str::slug($request->name);
        if($request->hasFile('image')){
            if(File::exists(public_path('uploads/categories').'/'.$category->image)){
                File::delete(public_path('uploads/categories').'/'.$category->image);
            }
            $image = $request->file('image');
            $file_extension = $request->file('image')->extension();
            $file_name = Carbon::now()->timestamp.'.'.$file_extension;
            $this->GenerateCategoryThumbnailsImage($image,$file_name);
            $category->image = $file_name;
        }
        
        $category->save();
        return redirect()->route('admin.categories')->with('status','Category has been updated successfully!');
    }

    public function category_delete($id){
        $category = Category::find($id);
        if(File::exists(public_path('uploads/categories').'/'.$category->image)){
            File::delete(public_path('uploads/categories').'/'.$category->image);
        }
        $category->delete();
        return redirect()->route('admin.categories')->with('status','Category has been deleted successfully!');
    }

    // product pages
    public function products(){
        $products = Product::orderBy('created_at','DESC')->paginate(10);
        return view('admin.products',compact('products'));
    }

    public function product_add(){
        $categories = Category::select('id','name')->orderBy('name')->get();
        $brands = Brand::select('id','name')->orderBy('name')->get();
        return view('admin.product-add',compact('categories','brands'));
    }

    public function product_store(Request $request){
        // dd($request->all());
        $request->validate([
            'name' => 'required',
            'slug' => 'required|unique:products,slug',
            'short_description' => 'required',
            'description' => 'required',
            'regular_price' => 'required',
            'sale_price' => 'required',
            'SKU' => 'required',
            'wardrobe' => 'required',
            'stock_status' => 'required',
            'featured' => 'required',
            'quantity' => 'required',
            'image' => 'required|mimes:png,jpg,jpeg,svg|max:2048',
            'category_id' => 'required',
            'brand_id' => 'required',
            'size_color_quantity' => 'required|array',
            // 'sizes' => 'required|array',
            // 'colors' => 'required|array',
            // 'quantities' => 'required|array',
            // 'quantities.*' => 'numeric|min:1',
        ]);

        $product = new Product();
        $product->name = $request->name;
        $product->slug = Str::slug($request->name);
        $product->short_description = $request->short_description;
        $product->description = $request->description;
        $product->regular_price = $request->regular_price;
        $product->sale_price = $request->sale_price;
        $product->SKU = $request->SKU;
        $product->wardrobe = $request->wardrobe;
        $product->stock_status = $request->stock_status;
        $product->featured = $request->featured;
        $product->quantity = $request->quantity;
        $product->category_id = $request->category_id;
        $product->brand_id = $request->brand_id;

        $current_timestamp = Carbon::now()->timestamp;

        if($request->hasFile('image'))
        {
            $image = $request->file('image');
            $imageName = $current_timestamp.'.'.$image->extension();
            $this->GenerateProductThumbnailImage($image,$imageName);
            $product->image = $imageName;
        }

        $gallery_arr = array();
        $gallery_images = "";
        $counter = 1;

        if($request->hasFile('images'))
        {
            $allowedfileExtension = ['jpg','png','jpeg','svg'];
            $files = $request->file('images');
            foreach($files as $file){
                $gextension = $file->getClientOriginalExtension();
                $gcheck = in_array($gextension,$allowedfileExtension);
                if($gcheck){
                    $gfileName = $current_timestamp."-".$counter.'.'.$gextension;
                    $this->GenerateProductThumbnailImage($file, $gfileName);
                    array_push($gallery_arr,$gfileName);
                    $counter = $counter + 1;
                }
            }
            $gallery_images = implode(',',$gallery_arr);
        }
        $product->images = $gallery_images;
        $product->save();

        // if ($request->has('sizes')) {
        //     $product->setMetaValue('sizes', $request->sizes);
        // }


        $sizeColorQuantities = $request->input('size_color_quantity', []);

        foreach ($sizeColorQuantities as $entry) {
            $size = $entry['size'];
            $colors = $entry['color'] ?? [];
            $quantities = $entry['quantity'] ?? [];

            foreach ($colors as $index => $color) {
                $quantity = $quantities[$index] ?? 0;
                if ($quantity > 0) {
                    $key = "{$size}_{$color}";
                    $product->setMetaValue($key, $quantity);
                }
            }
        }


        return redirect()->route('admin.products')->with('status','Product has been added successfully!');
    }

    public function GenerateProductThumbnailImage($image, $imageName){
        $destinationPathThumbnail = public_path('uploads/products/thumbnails');
        $destinationPath = public_path('uploads/products');
        $img = Image::read($image->path()); 

        $img->cover(540,689,"top"); //height, width, position
        $img->resize(540,689,function($constraint){
            $constraint->aspectRatio();
        })->save($destinationPath.'/'.$imageName);

        $img->resize(104,104,function($constraint){
            $constraint->aspectRatio();
        })->save($destinationPathThumbnail.'/'.$imageName);
    }

    public function product_edit($id){
        $product = Product::find($id);
        $categories = Category::select('id','name')->orderBy('name')->get();
        $brands = Brand::select('id','name')->orderBy('name')->get();
        // $sizesMeta = ProductMeta::where('product_id', $id)
        //                     ->where('key', 'sizes')  // Filter for the 'sizes' meta key
        //                     ->first();
        
        // $sizes = $sizesMeta ? explode(',',$sizesMeta->value) : [];

        $productMeta = ProductMeta::where('product_id', $id)->pluck('value', 'key')->toArray();
        $sizes = $productMeta;
        // dd($sizes);
        return view('admin.product-edit',compact('product','categories','brands','sizes'));
    }

    public function product_update(Request $request){
        $request->validate([
            'name' => 'required',
            'slug' => 'required|unique:products,slug,'.$request->id,
            'short_description' => 'required',
            'description' => 'required',
            'regular_price' => 'required',
            'sale_price' => 'required',
            'SKU' => 'required',
            'wardrobe' => 'required',
            'stock_status' => 'required',
            'featured' => 'required',
            'quantity' => 'required',
            'image' => 'mimes:png,jpg,jpeg,svg|max:2048',
            'category_id' => 'required',
            'brand_id' => 'required',
            'size_color_quantity' => 'required|array',
        ]);

        $product = Product::find($request->id);
        $product->name = $request->name;
        $product->slug = Str::slug($request->name);
        $product->short_description = $request->short_description;
        $product->description = $request->description;
        $product->regular_price = $request->regular_price;
        $product->sale_price = $request->sale_price;
        $product->SKU = $request->SKU;
        $product->wardrobe = $request->wardrobe;
        $product->stock_status = $request->stock_status;
        $product->featured = $request->featured;
        $product->quantity = $request->quantity;
        $product->category_id = $request->category_id;
        $product->brand_id = $request->brand_id;

        $current_timestamp = Carbon::now()->timestamp;

        if($request->hasFile('image'))
        {
            if(File::exists(public_path('uploads/products').'/'.$product->image)){
                File::delete(public_path('uploads/products').'/'.$product->image);
            }

            if(File::exists(public_path('uploads/products/thumbnails').'/'.$product->image)){
                File::delete(public_path('uploads/products/thumbnails').'/'.$product->image);
            }
            $image = $request->file('image');
            $imageName = $current_timestamp.'.'.$image->extension();
            $this->GenerateProductThumbnailImage($image,$imageName);
            $product->image = $imageName;
        }

        $gallery_arr = array();
        $gallery_images = "";
        $counter = 1;

        if($request->hasFile('images'))
        {
            foreach(explode(',',$product->images) as $ofile){
                if(File::exists(public_path('uploads/products').'/'.$ofile)){
                    File::delete(public_path('uploads/products').'/'.$ofile);
                }
    
                if(File::exists(public_path('uploads/products/thumbnails').'/'.$ofile)){
                    File::delete(public_path('uploads/products/thumbnails').'/'.$ofile);
                }
            }
            $allowedfileExtension = ['jpg','png','jpeg','svg'];
            $files = $request->file('images');
            foreach($files as $file){
                $gextension = $file->getClientOriginalExtension();
                $gcheck = in_array($gextension,$allowedfileExtension);
                if($gcheck){
                    $gfileName = $current_timestamp."-".$counter.'.'.$gextension;
                    $this->GenerateProductThumbnailImage($file, $gfileName);
                    array_push($gallery_arr,$gfileName);
                    $counter = $counter + 1;
                }
            }
            $gallery_images = implode(',',$gallery_arr);
            $product->images = $gallery_images;

        }
        $product->save();

        // $sizes = $request->sizes ? implode(',', $request->sizes) : ''; // Convert array of sizes to a comma-separated string

        // Check if sizes metadata already exists

        // $productId = $request->id;
        // $productMeta = ProductMeta::where('product_id', $productId)
        //                         ->where('key', 'sizes')
        //                         ->first();

        // if ($productMeta) {
        //     // If sizes metadata already exists, update the value
        //     $productMeta->value = $sizes;
        //     $productMeta->save();
        // } else {
        //     // If sizes metadata does not exist, create a new record
        //     ProductMeta::create([
        //         'product_id' => $productId,
        //         'key' => 'sizes',
        //         'value' => $sizes,
        //     ]);
        // }

        $productId = $product->id;
    
    // Remove old sizes/colors/quantities meta for this product
    ProductMeta::where('product_id', $productId)->delete();

    // Process new size, color, and quantity data
    foreach ($request->size_color_quantity as $sizeIndex => $sizeData) {
        if (isset($sizeData['size'])) {
            $size = $sizeData['size'];

            if (isset($sizeData['color']) && isset($sizeData['quantity'])) {
                foreach ($sizeData['color'] as $colorIndex => $color) {
                    $quantity = $sizeData['quantity'][$colorIndex];

                    // Save each size, color, and quantity combination in ProductMeta
                    ProductMeta::create([
                        'product_id' => $productId,
                        'key' => "{$size}_{$color}",
                        'value' => $quantity,
                    ]);
                }
            }
        }
    }

        return redirect()->route('admin.products')->with('status','Product has been updated successfully!');
    }

    public function product_delete($id){
        $product = Product::find($id);
        if(File::exists(public_path('uploads/products').'/'.$product->image)){
            File::delete(public_path('uploads/products').'/'.$product->image);
        }
        if(File::exists(public_path('uploads/products/thumbnails').'/'.$product->image)){
            File::delete(public_path('uploads/products/thumbnails').'/'.$product->image);
        }

        foreach(explode(',',$product->images) as $ofile){
            if(File::exists(public_path('uploads/products').'/'.$ofile)){
                File::delete(public_path('uploads/products').'/'.$ofile);
            }

            if(File::exists(public_path('uploads/products/thumbnails').'/'.$ofile)){
                File::delete(public_path('uploads/products/thumbnails').'/'.$ofile);
            }
        }
        $product->delete();
        return redirect()->route('admin.products')->with('status','Product has been deleted successfully');
    }


// coupon section
    public function coupons(){
        $coupons = Coupon::orderBy('expiry_date','DESC')->paginate(12);
        $results = null;
        return view('admin.coupons',compact('coupons','results'));
    }

    public function coupon_add(){
        return view('admin.coupon-add');
    }

    public function coupon_store(Request $request){
        $request->validate([
            'code'=>'required',
            'type'=>'required',
            'value'=>'required|numeric',
            'cart_value'=>'required|numeric',
            'expiry_date'=>'required|date',
        ]);
        $coupon = new Coupon();
        $coupon->code = $request->code;
        $coupon->type = $request->type;
        $coupon->value = $request->value;
        $coupon->cart_value = $request->cart_value;
        $coupon->expiry_date = $request->expiry_date;
        $coupon->save();
        return redirect()->route('admin.coupons')->with('status','Coupon has been added successfully!');
    }

    public function coupon_edit($id){
        $coupon = Coupon::find($id);
        return view('admin.coupon-edit',compact('coupon'));
    }

    public function coupon_update(Request $request){
        $request->validate([
            'code'=>'required',
            'type'=>'required',
            'value'=>'required|numeric',
            'cart_value'=>'required|numeric',
            'expiry_date'=>'required|date',
        ]);
        $coupon =Coupon::find($request->id);
        $coupon->code = $request->code;
        $coupon->type = $request->type;
        $coupon->value = $request->value;
        $coupon->cart_value = $request->cart_value;
        $coupon->expiry_date = $request->expiry_date;
        $coupon->save();
        return redirect()->route('admin.coupons')->with('status','Coupon has been updated successfully!');
    }

    public function coupon_delete($id){
        $coupon = Coupon::find($id);
        $coupon->delete();
        return redirect()->route('admin.coupons')->with('status','Coupon has been deleted successfully!');
    }

    // orders
    public function orders(){
        $orders = Order::orderBy('created_at','DESC')->paginate(12);
        $results = null;
        return view('admin.orders',compact('orders','results'));
    }

    public function order_details($order_id){
        $order = Order::find($order_id);
        $orderItems = OrderItem::where('order_id',$order_id)->orderBy('id')->paginate(12);
        $transaction = Transaction::where('order_id',$order_id)->first();
        return view('admin.order-details',compact('order','orderItems','transaction'));
    }

    public function update_order_status(Request $request){
        $order = Order::find($request->order_id);
        $order->status = $request->order_status;
        if($request->order_status == 'delivered'){
            $order->delivered_date = Carbon::now();
            $order->canceled_date = null;
        }
        else if($request->order_status == 'canceled'){
            $order->canceled_date = Carbon::now();
            $order->delivered_date = null;
        }
        $order->save();

        if($request->order_status == 'delivered'){
            $transaction = Transaction::where('order_id',$request->order_id)->first();
            $transaction->status = 'approved';
            $transaction->save();
        }
        else if($request->order_status == 'canceled'){
            $transaction = Transaction::where('order_id',$request->order_id)->first();
            $transaction->status = 'declined';
            $transaction->save();
        }
        return back()->with('status','Status changed successfully!');
    }

// slider section
    public function slides(){
        $slides = Slide::orderBy('id','DESC')->paginate(12);
        return view('admin.slides',compact('slides'));
    }

    public function slide_add(){
        return view('admin.slide-add');
    }

    public function slide_store(Request $request){
        $request->validate([
            'tagline' => 'required',
            'title' => 'required',
            'subtitle' => 'required',
            'link' => 'required',
            'status' => 'required',
            'image' => 'required|mimes:png,jpg,jpeg|max:2048',
        ]);
        $slide = new Slide();
        $slide->tagline = $request->tagline;
        $slide->title = $request->title;
        $slide->subtitle = $request->subtitle;
        $slide->link = $request->link;
        $slide->status = $request->status;

        $image = $request->file('image');
        $file_extension = $request->file('image')->extension();
        $file_name = Carbon::now()->timestamp.'.'.$file_extension;
        $this->GenerateSlideThumbnailsImage($image,$file_name);
        $slide->image = $file_name;
        $slide->save();

        return redirect()->route('admin.slides')->with('status','Slide added successfully!');
    }

    public function GenerateSlideThumbnailsImage($image, $imageName){
        $destinationPath = public_path('uploads/slides');
        $img = Image::read($image->path()); 
        $img->cover(1440,660,"top"); //height, width, position
        $img->resize(1440,660,function($constraint){
            $constraint->aspectRatio();
        })->save($destinationPath.'/'.$imageName);
    }

    public function slide_edit($id){
        $slide = Slide::find($id);
        return view('admin.slide-edit',compact('slide'));
    }

    public function slide_update(Request $request){
        $request->validate([
            'tagline' => 'required',
            'title' => 'required',
            'subtitle' => 'required',
            'link' => 'required',
            'status' => 'required',
            'image' => 'mimes:png,jpg,jpeg|max:2048',
        ]);
        // dd($request->tagline);
        $slide = Slide::find($request->id);
        // dd($request->id);
        $slide->tagline = $request->tagline;
        $slide->title = $request->title;
        $slide->subtitle = $request->subtitle;
        $slide->link = $request->link;
        $slide->status = $request->status;
        $current_timestamp = Carbon::now()->timestamp;

        if($request->hasFile('image'))
        {
            if(File::exists(public_path('uploads/slides').'/'.$slide->image)){
                File::delete(public_path('uploads/slides').'/'.$slide->image);
            }
            $image = $request->file('image');
            $imageName = $current_timestamp.'.'.$image->extension();
            $this->GenerateSlideThumbnailsImage($image,$imageName);
            $slide->image = $imageName;
        }

        $slide->save();

        return redirect()->route('admin.slides')->with('status','Slide updated successfully!');
    }

    public function slide_delete($id){
        $slide = Slide::find($id);
        if(File::exists(public_path('uploads/slides').'/'.$slide->image)){
            File::delete(public_path('uploads/slides').'/'.$slide->image);
        }

        $slide->delete();
        return redirect()->route('admin.slides')->with('status','Slide has been deleted successfully');
    }

    // Contact Information
    public function contact_info(){
        $contact_info = ContactInformation::first();
        return view('admin.contact-info',compact('contact_info'));
    }

    public function contact_info_add(){
        return view('admin.contact-info-add');
    }

    public function contact_info_store(Request $request){
        $request->validate([
            'address' => 'required',
            'email' => 'required',
            'phone' => 'required',
        ]);
        $contact_info = new ContactInformation();
        $contact_info->address = $request->address;
        $contact_info->email = $request->email;
        $contact_info->phone = $request->phone;

        $contact_info->save();

        return redirect()->route('admin.contact.info')->with('status','Contact Information added successfully!');
    }

    public function contact_info_edit($id){
        $contact_info = ContactInformation::find($id);
        return view('admin.contact-info-edit',compact('contact_info'));
    }

    public function contact_info_update(Request $request){
        $request->validate([
            'address' => 'required',
            'email' => 'required',
            'phone' => 'required'
        ]);

        $contact_info = ContactInformation::find($request->id);
        $contact_info->address = $request->address;
        $contact_info->email = $request->email;
        $contact_info->phone = $request->phone;

        $contact_info->save();

        return redirect()->route('admin.contact.info')->with('status','Contact Information updated successfully!');
    }

    public function contact_info_delete($id){
        $contact_info = ContactInformation::find($id);

        $contact_info->delete();
        return redirect()->route('admin.contact.info')->with('status','Contact Information has been deleted successfully');
    }

    // contact section
    public function contacts(){
        $contacts = Contact::orderBy('created_at','DESC')->paginate(10);
        $results = null;
        return view('admin.contacts',compact('contacts','results'));
    }

    public function contact_delete($id){
        $contact = Contact::find($id);
        $contact->delete();
        return redirect()->route('admin.contacts')->with('status','Contact has been deleted successfully!');
    }

// search section
    public function search(Request $request){
        $query = $request->input('query');
        $results = Product::where('name','LIKE',"%{$query}%")->get()->take(8);
        return response()->json($results);
    }

    public function search_operation(Request $request){
        $query = $request->name;
        $url = $request->url;
        if($url == "orders"){
            $results = Order::where('name','LIKE',"%{$query}%")->paginate(6);
        }
        if($url == "products"){
            $results = Product::where('name','LIKE',"%{$query}%")->paginate(6);
        }
        if($url == "brands"){
            $results = Brand::where('name','LIKE',"%{$query}%")->paginate(6);
        }
        if($url == "categories"){
            $results = Category::where('name','LIKE',"%{$query}%")->paginate(6);
        }
        if($url == "slides"){
            $results = Slide::where('title','LIKE',"%{$query}%")->paginate(6);
        }
        if($url == "coupons"){
            $results = Coupon::where('code','LIKE',"%{$query}%")->paginate(6);
        }
        if($url == "contacts"){
            $results = Contact::where('name','LIKE',"%{$query}%")->paginate(6);
        }
        if($url == "users"){
            $results = User::where('name','LIKE',"%{$query}%")->paginate(6);
        }
        return view("admin.".$url,compact('results'));
    }

    // user section
    public function users(){
        $users = User::where('utype','USR')->paginate(10);
        $admins = User::where('utype','ADM')->paginate(10);
        return view('admin.users',compact('users','admins'));
    }

    public function user_delete($id){
        $user = User::find($id);
        if($user->utype == 'ADM'){
            $user->delete();
            return redirect()->route('admin.users')->with('status_admin','Admin has been deleted successfully!');
        }
        $user->delete();
        return redirect()->route('admin.users')->with('status','User has been deleted successfully!');
    }

    public function settings(){
        return view('admin.settings');
    }

    public function setting_update(Request $request){
        $request->validate([
            'name'=>'required|max:100',
            'mobile'=>'required|numeric:digits:10',
            'email'=>'required|email',
            'image' => 'mimes:png,jpg,jpeg,svg|max:2048',
            'old_password'=>'required',
            'password'=>'required|string|min:8|confirmed',
        ]);

        $old_password = $request->old_password;
        $current_user = User::find($request->id)->getAttributes();
        $current_password = $current_user['password'];
        if (Hash::check($old_password, $current_password)){
            $admin = User::find($request->id);
            $password = $request->password;
            $hash_password = Hash::make($password);
            $admin->name = $request->name;
            $admin->mobile = $request->mobile;
            $admin->email = $request->email;
            $admin->password = $hash_password;

            $current_timestamp = Carbon::now()->timestamp;

            if($request->hasFile('image'))
            {
                $image = $request->file('image');
                $imageName = $current_timestamp.'.'.$image->extension();
                $this->GenerateProfileImage($image,$imageName);
                $admin->profile_picture = $imageName;
            }

            $admin->save();
            return redirect()->route('admin.settings')->with('success','Account updated successfully!');
        }
        else{
            return redirect()->route('admin.settings')->with('error','Account credientials did not match!');
        }
    }

    public function GenerateProfileImage($image, $imageName){
        $destinationPath = public_path('uploads/profile');
        $img = Image::read($image->path()); 

        $img->cover(360,360,"top"); //height, width, position
        $img->resize(360,360,function($constraint){
            $constraint->aspectRatio();
        })->save($destinationPath.'/'.$imageName);
    }

    // about section
    public function about(){
        $about = About::all()->first();;
        return view('admin.about-page',compact('about'));
    }

    public function about_store(Request $request){
        // dd($request->all());
        $request->validate([
            'main_intro'=>'required',
            'intro'=>'required',
            'mission'=>'required',
            'vision'=>'required',
            'company'=>'required',
            'cover_image'=>'mimes:png,jpg,jpeg|max:2048',
            'company_image'=>'mimes:png,jpg,jpeg|max:2048',
        ]);
        $about = new About();
        $about->main_intro=$request->main_intro;
        $about->intro=$request->intro;
        $about->mission=$request->mission;
        $about->vision=$request->vision;
        $about->company=$request->company;

        if($request->hasFile('cover_image'))
        {
            $cover_image = $request->file('cover_image');
            $file_extension = $request->file('cover_image')->extension();
            $file_name = Carbon::now()->timestamp . '_cover.' . $file_extension;
            $this->GenerateAboutCoverThumbnailsImage($cover_image,$file_name);
            $about->cover_image = $file_name;
        }

        if($request->hasFile('company_image'))
        {
            $company_image = $request->file('company_image');
            $file_extension1 = $request->file('company_image')->extension();
            $file_name1 = Carbon::now()->timestamp . '_company.' . $file_extension1;
            $this->GenerateAboutCoverThumbnailsImage($company_image,$file_name1);
            $about->company_image = $file_name1;
        }
        // dd($about->cover_image);
        $about->save();

        return redirect()->back()->with('status', 'About details added succcessfully!');
    }

    public function about_update(Request $request){
        // dd($request->all());
        $request->validate([
            'main_intro'=>'required',
            'intro'=>'required',
            'mission'=>'required',
            'vision'=>'required',
            'company'=>'required',
            'cover_image'=>'mimes:png,jpg,jpeg|max:2048',
            'company_image'=>'mimes:png,jpg,jpeg|max:2048',
        ]);
        // dd($request->all());
        $about = About::find($request->id);
        $about->main_intro=$request->main_intro;
        $about->intro=$request->intro;
        $about->mission=$request->mission;
        $about->vision=$request->vision;
        $about->company=$request->company;

        $current_timestamp = Carbon::now()->timestamp;

        if($request->hasFile('cover_image'))
        {
            if(File::exists(public_path('uploads/about').'/'.$about->cover_image)){
                File::delete(public_path('uploads/about').'/'.$about->cover_image);
            }
            $image = $request->file('cover_image');
            $imageName = $current_timestamp.'_cover.'.$image->extension();
            $this->GenerateAboutCoverThumbnailsImage($image,$imageName);
            $about->cover_image = $imageName;
        }

        if($request->hasFile('company_image'))
        {
            if(File::exists(public_path('uploads/about').'/'.$about->company_image)){
                File::delete(public_path('uploads/about').'/'.$about->company_image);
            }
            $image1 = $request->file('company_image');
            $imageName1 = $current_timestamp.'_company.'.$image1->extension();
            $this->GenerateAboutCoverThumbnailsImage($image1,$imageName1);
            $about->company_image = $imageName1;
        }
        $about->save();

        return redirect()->back()->with('status', 'About details updated succcessfully!');
    }

    public function GenerateAboutCoverThumbnailsImage($image, $imageName){
        $destinationPath = public_path('uploads/about');
        $img = Image::read($image->path()); 
        $img->cover(290,290,"top"); //width, height, position
        $img->resize(290,290,function($constraint){
            $constraint->aspectRatio();
        })->save($destinationPath.'/'.$imageName);
    }

    // public function GenerateAboutThumbnailsImage($image, $imageName){
    //     $destinationPath = public_path('uploads/about');
    //     $img = Image::read($image->path()); 
    //     $img->cover(500,450,"top"); //width, height, position
    //     $img->resize(500,450,function($constraint){
    //         $constraint->aspectRatio();
    //     })->save($destinationPath.'/'.$imageName);
    // }

    

// demo
    public function showForm(){
        return view('admin.repeater');
    }

    public function saveRepeater(Request $request){
        $request->validate([
            'items.*.title' => 'required|string|max:255',
            'items.*.description' => 'nullable|string',
            'items.*.image' => 'nullable|image|mimes:jpg,jpeg,png,svg|max:2048',
        ]);

        if ($request->has('items')) {
            foreach ($request->items as $item) {
                $imagePath = null;

                if (isset($item['image']) && $item['image'] instanceof \Illuminate\Http\UploadedFile) {
                    $imagePath = $item['image']->store('private/uploads', 'local');// 'local' points to storage/app
                }

                // Save each repeater item to the database
                RepeaterItem::create([
                    'title' => $item['title'],
                    'description' => $item['description'] ?? null,
                    'image' => $imagePath,
                ]);
            }
        }

        return back()->with('success', 'Repeater data saved successfully!');
    }
    
}