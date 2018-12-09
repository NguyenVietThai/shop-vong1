<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Product;

class AdminController extends Controller
{
    public function getSearch(Request $request){
    	$products = Product::where('name','like','%'.$request->key.'%' )
    						->orWhere('price',$request->key)
    						->get();
    	return view('admin.products',compact('products'));
    }
}
