<?php

namespace App\Http\Controllers;

use App\Domain\Product\Services\ProductServiceInterface;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;

class ProductController extends Controller
{
    private ProductServiceInterface $productService;

    public function __construct(ProductServiceInterface $productService)
    {
        $this->productService = $productService;
    }

    public function index(): Factory|View|Application
    {
        return view('products.index', ['products' => $this->productService->getAllProducts(9)]);
    }
}
