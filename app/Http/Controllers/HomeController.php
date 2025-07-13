<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\View\View;

class HomeController extends Controller
{
    /**
     * Show the home page with featured products.
     */
    public function index(): View
    {
        $featuredGames = Product::active()
            ->featured()
            ->games()
            ->with(['primaryImage', 'platform', 'categories'])
            ->take(8)
            ->latest()
            ->get();

        $featuredMerchandise = Product::active()
            ->featured()
            ->merchandise()
            ->with(['primaryImage', 'categories'])
            ->take(4)
            ->latest()
            ->get();

        $categories = Category::where('parent_id', null)
            ->with(['children'])
            ->orderBy('sort_order')
            ->take(6)
            ->get();

        $newReleases = Product::active()
            ->games()
            ->with(['primaryImage', 'platform'])
            ->orderBy('release_date', 'desc')
            ->take(6)
            ->get();

        return view('home', compact(
            'featuredGames',
            'featuredMerchandise',
            'categories',
            'newReleases'
        ));
    }
}
