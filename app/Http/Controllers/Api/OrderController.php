<?php

namespace App\Http\Controllers\Api;

use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Services\Midtrans\CreatePaymentUrlService;

class OrderController extends Controller
{
    public function order(Request $request)
    {
        $order = Order::create([
            'user_id' => $request->user()->id,
            'seller_id' => $request->seller_id,
            'number' => time(),
            'total_price' => $request->total_price,
            'payment_status' => 1,
            'delivery_address' => $request->delivery_address,
        ]);

        foreach ($request->items as $item) {
            if (isset($item['quantity'])) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item['id'],
                    'quantity' => $item['quantity']
                ]);
            } else {
                // Tindakan alternatif jika kunci 'quantity' tidak ditemukan
                Log::error('Key "quantity" not found in item:', $item);
            }
        }

        //manggil service midtrans untuk dapatkan payment url
        $midtrans = new CreatePaymentUrlService();
        $paymentUrl = $midtrans->getPaymentUrl($order->load('user', 'orderItems'));
        dd($paymentUrl);
        $order->update([
            'payment_url' => $paymentUrl
        ]);

        return response()->json([
            'data' => $order
        ]);
    }
}
