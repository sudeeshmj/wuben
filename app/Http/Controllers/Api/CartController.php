<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CartRequest;
use App\Repositories\CartRepository;
use App\Traits\ApiResponseTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    use ApiResponseTrait;
    protected $cartRepository;

    public function __construct(CartRepository $cartRepository)
    {
        $this->cartRepository = $cartRepository;
    }

    public function addToCart(CartRequest $request)
    {
        $userId = Auth::id();
        $cartItem = $this->cartRepository->addToCart($userId, $request->product_id, $request->quantity);

        return $this->successResponse($cartItem, "Product added to cart successfully.", 200);
    }

    public function removeFromCart(Request $request)
    {
        $request->validate(['product_id' => 'required|exists:cart_items,product_id']);
        $userId = Auth::id();
        $deleted = $this->cartRepository->removeFromCart($userId, $request->product_id);

        if ($deleted) {
            return response()->json(['status' => true, 'message' => 'Product removed from cart.'], 200);
        }

        return response()->json(['status' => false, 'message' => 'Product not found in cart.'], 404);
    }

    public function getCart()
    {
        $userId = Auth::id();
        $cartItems = $this->cartRepository->getCartItems($userId);
        return $this->successResponse($cartItems, "Cart retrieved successfully.", 200);
    }

    public function clearCart()
    {
        $userId = Auth::id();
        $this->cartRepository->clearCart($userId);
        return response()->json(['status' => true, 'message' => 'Cart cleared successfully.'], 200);
    }
}
