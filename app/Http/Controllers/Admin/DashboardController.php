<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
{
    // Stats Cards Data
    $totalProducts = Product::count();
    $totalCategories = Category::whereNull('parent_id')->count();
    $totalCustomers = User::where('role', 'customer')->count();
    $totalRevenue = 0; // Placeholder

    // Recent Products Data
    $recentProducts = Product::with('category', 'images')->latest()->take(5)->get();

    // Recent Customers Data
    $recentCustomers = User::where('role', 'customer')->latest()->take(5)->get();

    return view('admin.dashboard', compact(
        'totalProducts',
        'totalCategories',
        'totalCustomers',
        'totalRevenue',
        'recentProducts', 
        'recentCustomers' 
    ));
}
}