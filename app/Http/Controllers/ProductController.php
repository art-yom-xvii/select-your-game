<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Models\Platform;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ProductController extends Controller
{
    /**
     * Display a listing of the products with filters.
     */
    public function index(Request $request): View
    {
        $query = Product::active()->with(['primaryImage', 'categories']);

        // Filter by category if provided
        if ($request->has('category')) {
            $category = Category::where('slug', $request->category)->firstOrFail();
            $query->whereHas('categories', function ($q) use ($category) {
                $q->where('categories.id', $category->id);
            });
        }

        // Filter by platform if provided
        if ($request->has('platform')) {
            $platform = Platform::where('slug', $request->platform)->firstOrFail();
            $query->where('platform_id', $platform->id);
        }

        // Filter by product type
        if ($request->has('type')) {
            if ($request->type === 'games') {
                $query->games();
            } elseif ($request->type === 'merchandise') {
                $query->merchandise();
            }
        }

        // Sort options
        if ($request->has('sort')) {
            switch ($request->sort) {
                case 'price-asc':
                    $query->orderBy('price', 'asc');
                    break;
                case 'price-desc':
                    $query->orderBy('price', 'desc');
                    break;
                case 'newest':
                    $query->orderBy('created_at', 'desc');
                    break;
                case 'bestselling':
                    // This would require additional logic to track bestsellers
                    $query->orderBy('created_at', 'desc');
                    break;
                default:
                    $query->orderBy('created_at', 'desc');
            }
        } else {
            $query->orderBy('created_at', 'desc');
        }

        $products = $query->paginate(16);
        $categories = Category::where('is_active', true)->orderBy('sort_order')->get();
        $platforms = Platform::where('is_active', true)->get();

        return view('products.index', compact('products', 'categories', 'platforms'));
    }

    /**
     * Display the specified product.
     */
    public function show(string $slug): View
    {
        $product = Product::where('slug', $slug)
            ->active()
            ->with([
                'images',
                'categories',
                'platform',
            ])
            ->firstOrFail();

        // Get related products
        $relatedProducts = Product::active()
            ->where('id', '!=', $product->id)
            ->where(function ($query) use ($product) {
                // Same categories
                $query->whereHas('categories', function ($q) use ($product) {
                    $q->whereIn('categories.id', $product->categories->pluck('id'));
                });

                // Or same platform (if it's a game)
                if ($product->platform_id) {
                    $query->orWhere('platform_id', $product->platform_id);
                }
            })
            ->with(['primaryImage'])
            ->take(4)
            ->get();

        return view('products.show', compact('product', 'relatedProducts'));
    }
}
