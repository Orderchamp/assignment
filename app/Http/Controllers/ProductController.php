<?php

namespace App\Http\Controllers;

use App\Domain\Product\Services\ProductServiceInterface;

class ProductController extends Controller
{
    private ProductServiceInterface $productService;

    public function __construct(ProductServiceInterface $productService)
    {
        $this->productService = $productService;
    }

    public function index()
    {
        return view('products.index', ['products' => $this->productService->getAllProducts(9)]);
    }
}
