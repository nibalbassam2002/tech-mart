<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
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

        // 3. ▼▼▼ THIS IS THE CORRECTED PART ▼▼▼
        // Fetch only ONE product that has an active special offer
        $featuredOffers = Product::whereNotNull('discount_price')
                                ->where('offer_ends_at', '>', now())
                                ->with('images')
                                ->get(); // <-- Use get() to fetch a collection
        
        return view('frontend.home', [
            'categories' => $categories,
            'latestProducts' => $latestProducts,
            'featuredOffers' => $featuredOffers, // Pass the collection (plural)
        ]);
    }
}