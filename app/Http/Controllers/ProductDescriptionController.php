<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Description;
use App\Product;

class ProductDescriptionController extends Controller
{
    public function index($productId)
    {
        return Description::ofProduct($productId)->paginate();
    }

    public function store($productId, Request $request)
    {
        $this->validate($request, [
            'body' => 'required'
        ]);

        $product = Product::findOrFail($productId);

        $product->descriptions()->save(
            new Description(['body' => $request->input('body')])
        );

        return $product->descriptions;
    }
}
