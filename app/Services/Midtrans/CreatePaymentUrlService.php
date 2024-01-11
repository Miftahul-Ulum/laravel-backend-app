<?php

namespace App\Services\Midtrans;

use Midtrans\Snap;
use App\Models\Product;
use App\Services\Midtrans\Midtrans;
use Illuminate\Support\Collection;


class CreatePaymentUrlService extends Midtrans
{

    protected $order;

    public function __construct()
    {
        parent::__construct();

        // $this->order = $order;
    }

    public function getPaymentUrl($order)
    {
        $item_details = new Collection();

        foreach ($order->orderItems as $item) {
            $product = Product::find($item->product_id);
            $item_details->push([
                'id' => $product->id,
                'price' => $product->price,
                'quantity' => (int)$item->qty, // Pastikan quantity adalah angka
                'name' => $product->name,
            ]);
        }

        $totalItemPrice = $item_details->sum('price') * 100; // Ubah ke format yang diharapkan oleh Midtrans (dalam satuan sen)

        $params = [
            'transaction_details' => [
                'order_id' => $order->number,
                'gross_amount' => $totalItemPrice,
            ],
            'item_details' => $item_details->toArray(),
            'customer_details' => [
                'first_name' => $order->user->name,
                'email' => $order->user->email,
            ]
        ];

        $paymentUrl = Snap::createTransaction($params)->redirect_url;

        return $paymentUrl;
    }
}
