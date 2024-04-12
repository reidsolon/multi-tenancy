<?php

namespace App\Http\Controllers\V1\User;

use App\Http\Controllers\Controller;
use App\Http\Resources\User\CartResource;
use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\QueryBuilder\QueryBuilder;

class CartController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $collection = QueryBuilder::for(Cart::class)
            ->allowedIncludes('user')
            ->with('product.photos')
            ->defaultSort('-created_at')
            ->getOrPaginate();

        return CartResource::collection($collection);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'product_id' => ['required', 'exists:products,id'],
        ]);

        return DB::transaction(function () {
            $product = Product::find(request()->product_id);
            $cart = auth()->user()->cart()->whereProductId(request()->product_id)->first();

            if (!$cart) {
                $cart = auth()->user()->cart()->create([
                    'product_id' => $product->id,
                    'amount_in_cents' => $product->price_in_cents
                ]);
            }

            return CartResource::make($cart->load('product.photos'));
        });
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Cart $cart)
    {
        $request->validate([
            'quantity' => ['required', 'numeric'],
        ]);

        return DB::transaction(function () use ($cart) {
            $cart->update([
                'quantity' => request()->quantity,
                'amount_in_cents' => $cart->product->price_in_cents * request()->quantity
            ]);

            return CartResource::make($cart->load('product.photos'));
        });
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Cart $cart)
    {
        $cart->delete();

        return response()->json([]);
    }
}
