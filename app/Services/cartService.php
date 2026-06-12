<?php

namespace App\Services;

use App\Models\Product;

class CartService
{
    // Get cart from session
    public function getCart()
    {
        return session()->get('cart', []);
    }

    // Add product to cart
    public function add($productId)
    {
        
        $product = Product::findOrFail($productId);

        $cart = $this->getCart();

        $price = $product->discounted_price
            ? $product->discounted_price
            : $product->price;

        // If product already exists
        if (isset($cart[$product->id])) {

            $cart[$product->id]['quantity']++;

        } else {

            $cart[$product->id] = [
                'product_id' => $product->id,
                'name'       => $product->en_name,
                'price'      => $price,
                'image'      => $product->image,
                'quantity'   => 1,
            ];
        }

        session()->put('cart', $cart);

        return $cart;
    }

    // Calculate cart total
    public function calculateTotal($cart)
    {
        return collect($cart)->sum(function ($item) {

            return $item['price'] * $item['quantity'];

        });
    }

    // Cart count
    public function cartCount($cart)
    {
        return array_sum(array_column($cart, 'quantity'));
    }

    // Update cart
    
    public function update($id, $action)
    {
        $cart = $this->getCart();

        if (isset($cart[$id])) {

            if ($action === 'plus') {
                $cart[$id]['quantity']++;
            }

            if ($action === 'minus') {

                if ($cart[$id]['quantity'] > 1) {
                    $cart[$id]['quantity']--;
                }
            }

            session()->put('cart', $cart);
        }

        return $cart;
    }

    // Remove item

    public function remove($id)
    {
        $cart = $this->getCart();

        if (isset($cart[$id])) {

            unset($cart[$id]);

            session()->put('cart', $cart);
        }

        return $cart;
    }

    // Remove selected items

    public function removeSelected($ids)
    {
        $cart = $this->getCart();

        foreach ($ids as $id) {

            unset($cart[$id]);
        }

        session()->put('cart', $cart);

        return $cart;
    }
}