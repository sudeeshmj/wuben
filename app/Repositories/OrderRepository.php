<?php

namespace App\Repositories;

use App\Interfaces\OrderInterface;
use App\Models\Order;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class OrderRepository implements OrderInterface
{
    public function createOrder($request)
    {
        $newOrderRow = [
            'user_id' => $request->user_id,
            'total_price' =>  $request->total_price,
            'status' => 1,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()

        ];

        $newOrderId = DB::table('orders')->insertGetId($newOrderRow);

        return $newOrderId;
    }
    public function createOrderItem($request, $orderId)
    {
        $newOrderTxnRow = [];

        foreach ($request->products as $product) {

            $newOrderTxnRow[] = [
                'order_id' => $orderId,
                'product_id' => $product['product_id'],
                'price' => $product['price'],
                'quantity' => $product['quantity'],
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ];
        }

        DB::table('order_items')->insert($newOrderTxnRow);

        return true;
    }
    public function getOrderHistory($userId)
    {
        return Order::where('user_id', $userId)
            ->with(['orderItems' => function ($query) {
                $query->select('id', 'order_id', 'product_id', 'quantity', 'price');
            }])
            ->orderBy('created_at', 'desc')
            ->get();
    }
}
