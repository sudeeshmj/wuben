<?php

namespace App\Interfaces;

interface OrderInterface
{
    public function createOrder($request);
    public function createOrderItem($request, $orderId);
    public function getOrderHistory($userId);
}
