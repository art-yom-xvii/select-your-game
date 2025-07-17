<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Facades\Log;

class CategoryController extends Controller
{
    /**
     * Display products from a specific category.
     */
    public function show(string $slug): View
    {
        Log::info('Attempting to show category', ['slug' => $slug]);

        $category = Category::query()
            ->where('slug', $slug)
            ->with(['children'])
            ->firstOrFail();

        Log::info('Category found', ['category' => $category->toArray()]);

        // Get all subcategories (if any)
        $categoryIds = [$category->id];
        foreach ($category->children as $child) {
            $categoryIds[] = $child->id;
        }

        // Get products from this category and its children
        $products = Product::query()
            ->active()
            ->whereHas('categories', function ($query) use ($categoryIds) {
                $query->whereIn('categories.id', $categoryIds);
            })
            ->with(['primaryImage', 'platform'])
            ->orderBy('created_at', 'desc')
            ->paginate(16);

        Log::info('Attempting to render view', [
            'view' => 'categories.show',
            'category_id' => $category->id,
            'products_count' => $products->count()
        ]);

        return view('categories.show', compact('category', 'products'));
    }
}
