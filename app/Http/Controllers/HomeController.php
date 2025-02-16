<?php

namespace App\Http\Controllers;

use App\Models\About;
use App\Models\Slide;
use App\Models\Contact;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Models\ContactInformation;

class HomeController extends Controller
{
    public function index()
    {
        $slides = Slide::where('status',1)->get()->take(3);
        $categories = Category::orderBy('name')->get();
        $sproducts = Product::whereNotNull('sale_price')->where('sale_price','<>','')->inRandomOrder()->get()->take(8);
        $sale_products = Product::whereNotNull('sale_price')->where('sale_price','<>','')->where('featured','1')->inRandomOrder()->get()->take(6);
        $fproducts = Product::where('featured','1')->get()->take(8);
        $about = About::all()->first();
        $contact_info = ContactInformation::first();
        return view('index',compact('slides','categories','sproducts','fproducts','about','sale_products','contact_info'));
    }

    public function contact(){
        $contact_info = ContactInformation::first();
        return view('contact', compact('contact_info'));
    }

    public function contact_store(Request $request){
        $request->validate([
            'name'=>'required|max:100',
            'email'=>'required|email',
            'phone'=>'required|numeric:digits:10',
            'comment'=>'required',
        ]);

        $contact = new Contact();
        $contact->name = $request->name;
        $contact->email = $request->email;
        $contact->phone = $request->phone;
        $contact->comment = $request->comment;
        $contact->save();

        return redirect()->back()->with('success','Your message has been sent successfully!');
    }

    public function about(){
        $about = About::all()->first();
        return view('about',compact('about'));
    }

    public function search(Request $request){
        $query = $request->input('query');
        $results = Product::where('name','LIKE',"%{$query}%")->get()->take(8);
        return response()->json($results);

    }
    public function search_items(Request $request){
        $query = $request->searchItem;
        $results = Product::where('name','LIKE',"%{$query}%")->paginate(12);
        return view('search-shop',compact('results'));

    }

}
