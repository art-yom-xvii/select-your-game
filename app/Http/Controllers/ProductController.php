<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Models\Platform;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\JsonResponse;

class ProductController extends Controller
{
    /**
     * Display a listing of the products with filters.
     */
    public function index(Request $request): View|JsonResponse
    {
        // Detailed logging of request parameters
        Log::channel('daily')->info('Product Index Request', [
            'categories' => $request['categories'] ?? null,
            'platforms' => $request['platforms'] ?? null,
            'type' => $request['type'] ?? null,
            'sort' => $request['sort'] ?? null,
        ]);

        // Start with base query
        $query = Product::active()->with(['primaryImage', 'platform', 'categories']);

        // Log total active products before filtering
        $totalActiveProducts = Product::active()->count();
        $totalProductTypes = Product::active()->select('product_type')->distinct()->get();

        Log::channel('daily')->info('Product Counts', [
            'total_active_products' => $totalActiveProducts,
            'product_types' => $totalProductTypes->pluck('product_type')->toArray(),
        ]);

        // Normalize input parameters
        $categories = $request['categories'] ?? [];
        $platforms = $request['platforms'] ?? [];
        $type = $request['type'] ?? null;
        $sort = $request['sort'] ?? 'newest';

        // Convert comma-separated strings to arrays if needed
        $categories = is_string($categories) ? explode(',', $categories) : $categories;
        $platforms = is_string($platforms) ? explode(',', $platforms) : $platforms;

        // Ensure arrays are of integers
        $categories = array_filter(array_map('intval', $categories));
        $platforms = array_filter(array_map('intval', $platforms));

        // Category filtering
        if (!empty($categories)) {
            $query->whereHas('categories', function ($q) use ($categories) {
                $q->whereIn('categories.id', $categories);
            });
        }

        // Platform filtering
        if (!empty($platforms)) {
            $query->whereIn('platform_id', $platforms);
        }

        // Product type filtering
        if ($type === 'games') {
            $query->where('product_type', 'game');
        } elseif ($type === 'merchandise') {
            $query->where('product_type', 'merchandise');
        }

        // Search filtering
        if ($request->filled('search')) {
            $search = $request->input('search');
            $words = preg_split('/\s+/', $search, -1, PREG_SPLIT_NO_EMPTY);
            $query->where(function($q) use ($words) {
                foreach ($words as $word) {
                    $normalized = strtolower(str_replace('-', '', $word));
                    $q->where(function($sub) use ($normalized) {
                        $sub->whereRaw('LOWER(REPLACE(name, "-", "")) LIKE ?', ["%{$normalized}%"])
                            ->orWhereRaw('LOWER(REPLACE(description, "-", "")) LIKE ?', ["%{$normalized}%"]);
                    });
                }
            });
        }

        // Sorting
        switch ($sort) {
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
                $query->orderBy('created_at', 'desc');
                break;
            default:
                $query->orderBy('created_at', 'desc');
        }

        // Paginate products
        $products = $query->paginate(16);

        // Check if this is an AJAX request
        if ($request->ajax()) {
            // Render just the product cards
            $html = view('products.partials.product-grid', compact('products'))->render();
            return response()->json([
                'html' => $html,
                'has_more' => $products->hasMorePages(),
                'current_page' => $products->currentPage(),
                'last_page' => $products->lastPage(),
            ]);
        }

        // Regular page view
        return view('products.index', [
            'products' => $products,
            'categories' => Category::active()->get(),
            'platforms' => Platform::active()->get(),
        ]);
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
