<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use App\Models\OrderItem;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Log;


class OrderController extends Controller
{
    public function store(Request $request)
    {
        $data = $request->validate([
            'customer_name' => 'required|string',
            'total_amount' => 'required|numeric',
            'items' => 'required|array',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.quantity' => 'required|integer|min:1',
        ]);

        $order = Order::create([
            'customer_name' => $data['customer_name'],
            'total_amount' => $data['total_amount'],
        ]);

        foreach ($data['items'] as $itemData) {
            $product = Product::findOrFail($itemData['product_id']);

            $orderItem = new OrderItem([
                'product_id' => $product->id,
                'quantity' => $itemData['quantity'],
            ]);

            $order->items()->save($orderItem);
        }

        Log::info('Order created', ['order_id' => $order->id]);

        return response()->json(['message' => 'Order created successfully'], 201);
    }

    public function update(Request $request, Order $order)
    {
        $data = $request->validate([
            'customer_name' => 'required|string',
            'total_amount' => 'required|numeric',
            'items' => 'required|array',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.quantity' => 'required|integer|min:1',
        ]);

        $order->update([
            'customer_name' => $data['customer_name'],
            'total_amount' => $data['total_amount'],
        ]);

        $order->items()->delete();

        foreach ($data['items'] as $itemData) {
            $product = Product::findOrFail($itemData['product_id']);

            $orderItem = new OrderItem([
                'product_id' => $product->id,
                'quantity' => $itemData['quantity'],
            ]);

            $order->items()->save($orderItem);
        }

        Log::info('Order updated', ['order_id' => $order->id]);

        return response()->json(['message' => 'Order updated successfully'], 200);
    }
}
