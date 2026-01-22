<?php

namespace App\Services;

use App\Models\Product;
use Illuminate\Support\Facades\Cache;

class ProductService
{
    /**
     * Get top selling products with caching.
     */
    public function getTopSelling($limit = 5)
    {
        return Cache::remember('top-selling-products', 3600, function () use ($limit) {
            return Product::topSelling()
                ->take($limit)
                ->get();
        });
    }

    /**
     * Get products in stock.
     */
    public function getInStock($perPage = 15)
    {
        return Product::inStock()
            ->paginate($perPage);
    }

    /**
     * Search products by keyword.
     */
    public function search($keyword, $perPage = 15)
    {
        return Product::search($keyword)
            ->inStock()
            ->paginate($perPage);
    }

    /**
     * Invalidate product cache.
     */
    public function invalidateCache(): void
    {
        Cache::forget('top-selling-products');
    }

    /**
     * Check if product is available for purchase.
     */
    public function isAvailable(Product $product): bool
    {
        return $product->stock > 0 && !$product->trashed();
    }
}
