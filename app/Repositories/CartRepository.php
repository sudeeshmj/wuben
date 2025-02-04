<?php

namespace App\Repositories;

use App\Models\CartItem;

class CartRepository
{
    public function addToCart($userId, $productId, $quantity)
    {

        $cartItem = CartItem::where('user_id', $userId)
            ->where('product_id', $productId)
            ->first();

        if ($cartItem) {
            $cartItem->increment('quantity', $quantity);
            return $cartItem;
        }

        return CartItem::create([
            'user_id' => $userId,
            'product_id' => $productId,
            'quantity' => $quantity,
        ]);
    }

    public function removeFromCart($userId, $productId)
    {
        return CartItem::where('user_id', $userId)
            ->where('product_id', $productId)
            ->delete();
    }

    public function getCartItems($userId)
    {
        return CartItem::where('user_id', $userId)
            ->with('product:id,name,price')
            ->get();
    }

    public function clearCart($userId)
    {
        return CartItem::where('user_id', $userId)->delete();
    }
}
