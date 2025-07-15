<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Models\Platform;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Facades\Log;

class ProductController extends Controller
{
    /**
     * Display a listing of the products with filters.
     */
    public function index(Request $request): View
    {
        // Detailed logging of request parameters
        Log::channel('daily')->info('Product Index Request', [
            'categories' => $request['categories'] ?? null,
            'platforms' => $request['platforms'] ?? null,
            'type' => $request['type'] ?? null,
            'sort' => $request['sort'] ?? null,
        ]);

        // Start with base query
        $query = Product::active()->with(['primaryImage', 'categories']);

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

        // Log filtering details
        Log::channel('daily')->info('Filtering Details', [
            'categories' => $categories,
            'platforms' => $platforms,
            'type' => $type,
            'sort' => $sort,
        ]);

        // Category filtering
        if (!empty($categories)) {
            Log::channel('daily')->info('Category Filtering', [
                'selected_category_ids' => $categories,
            ]);

            $query->whereHas('categories', function ($q) use ($categories) {
                $q->whereIn('categories.id', $categories);
            });

            // Log the SQL query for debugging
            Log::channel('daily')->info('Category Filter Query', [
                'query_sql' => $query->toSql(),
                'query_bindings' => $query->getBindings(),
            ]);
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

        // Log the final query details
        Log::channel('daily')->info('Product Query Details', [
            'query_sql' => $query->toSql(),
            'query_bindings' => $query->getBindings(),
        ]);

        // Paginate products
        $products = $query->paginate(16);

        // Log products details
        Log::channel('daily')->info('Products Retrieved', [
            'total_products' => $products->total(),
            'current_page_count' => $products->count(),
            'current_page' => $products->currentPage(),
        ]);

        // Get all active categories and platforms for filter display
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
