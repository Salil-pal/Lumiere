<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\CartService;
use App\Http\Requests\AddToCartRequest;

class CartController extends Controller
{
    protected $cartService;

    // Dependency Injection
    public function __construct(CartService $cartService)
    {
        $this->cartService = $cartService;
    }

    // Show cart page
    public function index()
    {
        return view('front.cart.index');
    }

    // Add to cart
    public function add(AddToCartRequest $request)
    {
        $cart = $this->cartService->add($request->id);

        return response()->json([
            'status' => 'success',
            'count'  => $this->cartService->cartCount($cart),
        ]);
    }

    // Update cart
    public function update(Request $request)
    {
        $cart = $this->cartService->update(
            $request->id,
            $request->action
        );

        $item = $cart[$request->id];

        return response()->json([
            'status'   => 'success',
            'quantity' => $item['quantity'],
            'subtotal' => $item['price'] * $item['quantity'],
            'total'    => $this->cartService->calculateTotal($cart),
            'count'    => $this->cartService->cartCount($cart),
        ]);
    }

    // Remove item
    public function remove(Request $request)
    {
        $cart = $this->cartService->remove($request->id);

        return response()->json([
            'status' => 'success',
            'total'  => $this->cartService->calculateTotal($cart),
            'count'  => $this->cartService->cartCount($cart),
        ]);
    }

    // Remove selected items
    public function removeSelected(Request $request)
    {
        $cart = $this->cartService->removeSelected($request->ids);

        return response()->json([
            'status' => 'success',
            'total'  => $this->cartService->calculateTotal($cart),
            'count'  => $this->cartService->cartCount($cart),
        ]);
    }
}