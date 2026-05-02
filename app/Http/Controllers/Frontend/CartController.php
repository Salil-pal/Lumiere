<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;

class CartController extends Controller
{
    // Show cart page
    public function index()
    {
        return view('front.cart.index');
    }

    

    // Add to cart (AJAX)
    public function add(Request $request)
    {
        $product = Product::findOrFail($request->id);

        $cart = session()->get('cart', []);

        $price = $product->discounted_price 
                    ? $product->discounted_price 
                    : $product->price;

        if(isset($cart[$product->id])) {
            $cart[$product->id]['quantity']++;
        } else {
            $cart[$product->id] = [
                "product_id" => $product->id,
                "name" => $product->en_name,
                "price" => $price,
                "image" => $product->image,
                "quantity" => 1
            ];
        }

        session()->put('cart', $cart);

        return response()->json([
            'status' => 'success',
            'count' => array_sum(array_column($cart, 'quantity'))
        ]);
    }

    // --------------- Update -------------

    public function update(Request $request)
    {
        $cart = session()->get('cart', []);

        if(isset($cart[$request->id])) {

            if($request->action == 'plus') {
                $cart[$request->id]['quantity']++;
            }

            if($request->action == 'minus') {
                if($cart[$request->id]['quantity'] > 1) {
                    $cart[$request->id]['quantity']--;
                }
            }

            session()->put('cart', $cart);
        }

        // calculate subtotal
        $item = $cart[$request->id];
        $subtotal = $item['price'] * $item['quantity'];

        // calculate total
        $total = 0;
        foreach($cart as $c){
            $total += $c['price'] * $c['quantity'];
        }

        return response()->json([
            'status' => 'success',
            'quantity' => $item['quantity'],
            'subtotal' => $subtotal,
            'total' => $total,
            'count' => array_sum(array_column($cart, 'quantity'))
        ]);
    }

    // --------------- Remove -------------

    public function remove(Request $request)
    {
        $cart = session()->get('cart', []);

        if(isset($cart[$request->id])) {
            unset($cart[$request->id]);
            session()->put('cart', $cart);
        }

        // recalculate
        $total = 0;
        foreach($cart as $item){
            $total += $item['price'] * $item['quantity'];
        }

        return response()->json([
            'status' => 'success',
            'total' => $total,
            'count' => array_sum(array_column($cart, 'quantity'))
        ]);
    }

    // --------------- Remove selected item -------------

    public function removeSelected(Request $request)
    {
        $cart = session()->get('cart', []);

        foreach($request->ids as $id){
            unset($cart[$id]);
        }

        session()->put('cart', $cart);

        $total = 0;
        foreach($cart as $item){
            $total += $item['price'] * $item['quantity'];
        }

        return response()->json([
            'total' => $total,
            'count' => array_sum(array_column($cart, 'quantity')),
        ]);
    }
}