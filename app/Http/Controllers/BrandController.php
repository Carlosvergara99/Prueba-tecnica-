<?php

namespace App\Http\Controllers;

use App\brand;
use Illuminate\Http\Request;

class BrandController extends Controller
{
    public function get()
    {
        $brand =brand::OrderBy('id', 'DESC')->get();
        return response()->json($brand);
    }
    public function store(Request $request)
    {
        $brand = new brand($request->all());
        $brand->save();
        return response()->json($brand);
    }
    public function update(Request $request)
    {
        $brand = brand::findOrFail($request->id);
         $brand->update($request->all());
       
        return response()->json($brand);
    }
    public function destroy(Request $request)
    {
        $brand = brand::find($request->id);
        $brand->delete();
    }
}
