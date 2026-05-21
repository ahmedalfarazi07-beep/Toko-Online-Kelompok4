<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;

class WelcomeController extends Controller
{
    public function index()
    {
        $products = Product::available()
            ->latest()
            ->take(8)
            ->get();

        $flashSaleProducts = Product::available()
            ->whereNotNull('discount_price')
            ->orderBy('discount_price')
            ->take(4)
            ->get();

        $categories = Category::all();

        return view('home', compact('products', 'flashSaleProducts', 'categories'));
    }
}
