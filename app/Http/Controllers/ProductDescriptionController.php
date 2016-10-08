<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

class ProductDescriptionController extends Controller
{
    public function index($productId)
    {
        return \App\Description::ofProduct($productId)->paginate();
    }

    public function store()
    {
        //
    }
}
