<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Resources\Json\ResourceCollection;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return new ResourceCollection(Product::paginate());
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        return $product;
    }
}
