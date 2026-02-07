<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Resources\ProductResource;

class ProductController extends Controller
{
    public function index()
    {
        return ProductResource::collection(Product::all());
    }
    /**
     * Get all available products with pagination.
     */
    public function index(Request $request): JsonResponse
    {
        $user = $request->user();
        $customer = $user ? $user->getOrCreateCustomer() : null;
        
        // Start with in-stock products using scope
        $query = Product::inStock();
        
        // Apply subscription-based access filtering
        if ($customer) {
            // All customers see regular products
            $query->where(function ($q) use ($customer) {
                $q->where('is_limited_edition', false);
                
                // Premium and Elite subscribers can see limited edition products
                if ($customer->canAccessLimitedEdition()) {
                    $q->orWhere('is_limited_edition', true);
                }
            });
        } else {
            // Non-authenticated users only see regular products
            $query->where('is_limited_edition', false);
        }

        // Optional search parameter
        if ($request->has('search')) {
            $search = $request->get('search');
            $query->search($search);
        }

        // Optional filtering by price range
        if ($request->has('min_price')) {
            $query->where('price', '>=', $request->min_price);
        }
        if ($request->has('max_price')) {
            $query->where('price', '<=', $request->max_price);
        }

        // Optional filtering by roast level
        if ($request->has('roast_level')) {
            $query->where('roast_level', $request->roast_level);
        }

        // Optional sorting
        $sortBy = $request->get('sort_by', 'created_at');
        $sortOrder = $request->get('sort_order', 'desc');
        $allowedSortFields = ['name', 'price', 'created_at', 'stock'];
        if (in_array($sortBy, $allowedSortFields)) {
            $query->orderBy($sortBy, $sortOrder);
        } else {
            $query->orderBy('created_at', 'desc');
        }

        // Pagination - default 15 items per page
        $perPage = min($request->get('per_page', 15), 100); // Max 100 items per page
        $products = $query->paginate($perPage);

        // Get subscription info for pricing
        $subscription = $customer ? $customer->activeSubscription()->first() : null;
        $discountPercent = $customer ? $customer->getSubscriptionDiscount() : 0;

        return response()->json([
            'success' => true,
            'message' => 'Products retrieved successfully',
            'data' => $products->map(function ($product) use ($discountPercent) {
                $originalPrice = (float) $product->price;
                $discountedPrice = $discountPercent > 0 
                    ? round($originalPrice * (1 - $discountPercent / 100), 2) 
                    : $originalPrice;
                
                return [
                    'id' => $product->product_id,
                    'name' => $product->name,
                    'description' => $product->description,
                    'price' => $originalPrice,
                    'formatted_price' => '$' . number_format($originalPrice, 2),
                    'discounted_price' => $discountPercent > 0 ? $discountedPrice : null,
                    'formatted_discounted_price' => $discountPercent > 0 ? '$' . number_format($discountedPrice, 2) : null,
                    'discount_percent' => $discountPercent > 0 ? $discountPercent : null,
                    'stock' => $product->stock,
                    'is_in_stock' => $product->is_in_stock,
                    'is_limited_edition' => $product->is_limited_edition,
                    'image' => $product->image_url,
                    'roast_level' => $product->roast_level,
                    'origin' => $product->origin,
                    'created_at' => $product->created_at->toISOString(),
                ];
            }),
            'meta' => [
                'current_page' => $products->currentPage(),
                'last_page' => $products->lastPage(),
                'per_page' => $products->perPage(),
                'total' => $products->total(),
                'from' => $products->firstItem(),
                'to' => $products->lastItem(),
            ],
            'links' => [
                'first' => $products->url(1),
                'last' => $products->url($products->lastPage()),
                'prev' => $products->previousPageUrl(),
                'next' => $products->nextPageUrl(),
            ],
        ], 200);
    }
}
