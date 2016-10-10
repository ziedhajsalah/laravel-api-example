<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Product;

class ProductController extends Controller
{
    public function index()
    {
        return Product::paginate();
    }

    public function show(Product $product)
    {
        return $product;
    }

    public function store(Request $request)
    {
        return Product::create([
            'name' => $request->input('name')
        ]);
    }

    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        $product->update([
            'name' => $request->input('name')
        ]);
    }
}
