<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Product;
use App\Models\Category;
use App\Models\ProductMeta;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ShopController extends Controller
{
    public function index(Request $request){
        // $size = $request->query('size')?$request->query('size'):6;
        // dd($request->query('size'));
        $pageshow = is_numeric($request->query('pageshow')) ? (int)$request->query('pageshow') : 6;
        $o_column = "";
        $o_order = "";
        $order = $request->query('order')?$request->query('order'):-1;
        $wardrobe = $request->query('wardrobe')?$request->query('wardrobe'):-1;
        // dd($order);
        $f_brands = $request->query('brands');
        $f_categories = $request->query('categories');
        $min_price = $request->query('min')? $request->query('min'):100;
        $max_price = $request->query('max')? $request->query('max'):10000;

        $w_column = null;
        $w_order = null;
        switch($wardrobe){
            case 'men':
                $w_column='wardrobe';
                $w_order='men';
                break;
            case 'women':
                $w_column='wardrobe';
                $w_order='women';
                break;
            case 'kid':
                $w_column='wardrobe';
                $w_order='kid';
                break;
        }

        switch($order){
            case 1:
                $o_column='created_at';
                $o_order='DESC';
                break;
            case 2:
                $o_column='created_at';
                $o_order='ASC';
                break;
            case 3:
                $o_column='sale_price';
                $o_order='ASC';
                break;
            case 4:
                $o_column='sale_price';
                $o_order='DESC';
                break;
            default:
                $o_column='id';
                $o_order='DESC';
        }
        $brands = Brand::orderBy('name','ASC')->get();
        $categories = Category::orderBy('name', 'ASC')->get();
        $products = Product::where(function($query) use($f_brands){
            $query->whereIn('brand_id',explode(',',$f_brands))->orWhereRaw("'".$f_brands."'=''");
        })->where(function($query) use($f_categories){
            $query->whereIn('category_id',explode(',',$f_categories))->orWhereRaw("'".$f_categories."'=''");
        })
        ->where(function($query) use($min_price, $max_price){
            $query->whereBetween('sale_price',[$min_price,$max_price])
            ->orWhereBetween('sale_price',[$min_price,$max_price]);
        })
        ->orderBy($o_column,$o_order)
        ->where($w_column,$w_order)->paginate($pageshow);
        return view('shop',compact('products','pageshow','order','wardrobe','brands','f_brands','categories','f_categories','min_price','max_price'));
    }

    public function product_details($product_slug){
        $product = Product::where('slug',$product_slug)->first();
        $productMeta = ProductMeta::where('product_id', $product->id)->pluck('value', 'key')->toArray();
        // dd($productMeta);
        $rproducts = Product::where('slug','<>',$product_slug)->get()->take(8);
        return view('details',compact('product','rproducts'));
    }
}
