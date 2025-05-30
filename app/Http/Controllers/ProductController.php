<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\JsonResponse;
class ProductController extends Controller
{
    public function index()
    {
        $products = Product::with(['stocks.warehouse'])->get();
        return view("products.list", compact("products"));
    }
}
