<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use App\Models\Attribute; 
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Display the homepage.
     */
    public function index()
    {
        // 1. Fetch main categories
        $categories = Category::whereNull('parent_id')->oldest()->get();

        // 2. Fetch latest products
        $latestProducts = Product::with('images')->latest()->take(8)->get();

        // 3. Fetch products with active special offers
        $featuredOffers = Product::whereNotNull('discount_price')
                                ->where('offer_ends_at', '>', now())
                                ->with('images')
                                ->get();
        
        return view('frontend.home', [
            'categories' => $categories,
            'latestProducts' => $latestProducts,
            'featuredOffers' => $featuredOffers,
        ]);
    }


}