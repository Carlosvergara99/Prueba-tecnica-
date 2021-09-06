<?php

namespace App\Http\Controllers;

use App\product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function get()
    {
        $product =product::with('brand')->OrderBy('id', 'DESC')->get();
        return response()->json($product);
    }
    public function store(Request $request)
    {
        $product = new product($request->all());
        $product->save();
        return response()->json($product);
    }
    public function update(Request $request)
    {
        $product = product::findOrFail($request->id);
        $product->update($request->all());
      
       return response()->json($product);
    }
    public function destory(Request $request)
    {
        $product = product::find($request->id);
        $product->delete();
    }
}
