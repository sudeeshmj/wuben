<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\OrderRequest;
use App\Interfaces\OrderInterface;
use App\Traits\ApiResponseTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    use ApiResponseTrait;

    protected $orderRepository;

    public function __construct(OrderInterface $orderRepository)
    {
        $this->orderRepository = $orderRepository;
    }


    public function store(OrderRequest $request)
    {
        DB::beginTransaction();
        try {
            $orderId = $this->orderRepository->createOrder($request);
            if (!$orderId) {

                return $this->errorResponse("Failed to place new order.");
            }

            $orderDetailsCreated = $this->orderRepository->createOrderItem($request, $orderId);

            if (!$orderDetailsCreated) {

                return $this->errorResponse("Failed to place new order.");
            }
            DB::commit();

            return $this->successResponse($orderId, "Successfully placed new order.", 201);
        } catch (\Exception $e) {

            DB::rollBack();

            return $this->errorResponse("Failed to place new order.");
        }
    }
    public function getOrderHistory($userId)
    {
        $orders = $this->orderRepository->getOrderHistory($userId);

        if ($orders->isEmpty()) {
            return $this->errorResponse("No orders found for this user.", 404);
        }
        return $this->successResponse($orders, "Order history retrieved successfully", 200);
    }
}
