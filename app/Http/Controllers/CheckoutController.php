<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;

class CheckoutController extends Controller
{
    public function index()
    {
        $cart = Session::get('cart');

        if (empty($cart)) {
            return redirect()->route('cart')->with('success', 'Keranjang Anda kosong.');
        }

        $tableNumber = Session::get('table_number');
        $subtotal = collect($cart)->sum(fn($item) => $item['price'] * $item['qty']);
        $tax = (int) ($subtotal * 0.1);
        $total = $subtotal + $tax;

        return view('customer.checkout', compact('cart', 'subtotal', 'tax', 'total', 'tableNumber'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'customer_name' => 'required|string|max:255',
            'customer_phone' => 'nullable|string|max:20',
            'note' => 'nullable|string',
            'payment_method' => 'required|in:cash,midtrans',
        ]);

        $cart = Session::get('cart');

        if (empty($cart)) {
            return redirect()->route('cart')->with('error', 'Keranjang Anda kosong.');
        }

        $tableNumber = Session::get('table_number', 1);
        $subtotal = collect($cart)->sum(fn($item) => $item['price'] * $item['qty']);
        $tax = (int) ($subtotal * 0.1);
        $grandTotal = $subtotal + $tax;

        // Find or create a guest user based on name + phone
        $user = User::firstOrCreate(
            [
                'phone_number' => $request->customer_phone ?? 'guest',
                'role_id' => 4, // Customer role
            ],
            [
                'username' => Str::slug($request->customer_name) . '_' . time(),
                'full_name' => $request->customer_name,
                'phone_number' => $request->customer_phone ?? 'guest',
                'email' => Str::slug($request->customer_name) . '_' . time() . '@guest.com',
                'password' => bcrypt(Str::random(16)),
                'role_id' => 4,
            ]
        );

        // Always update the full_name to the latest input
        $user->update(['full_name' => $request->customer_name]);

        $order = Order::create([
            'order_number' => 'ORD-' . strtoupper(Str::random(8)),
            'user_id' => $user->id,
            'subtotal' => $subtotal,
            'tax' => $tax,
            'grand_total' => $grandTotal,
            'status' => 'pending',
            'table_number' => $tableNumber,
            'payment_method' => $request->payment_method,
            'note' => $request->note,
        ]);

        foreach ($cart as $itemId => $cartItem) {
            $itemTax = (int) ($cartItem['price'] * $cartItem['qty'] * 0.1);
            $totalPrice = ($cartItem['price'] * $cartItem['qty']) + $itemTax;

            OrderItem::create([
                'order_id' => $order->id,
                'item_id' => $itemId,
                'quantity' => $cartItem['qty'],
                'price' => $cartItem['price'],
                'tax' => $itemTax,
                'total_price' => $totalPrice,
            ]);
        }

        Session::forget('cart');

        // --- CASH: redirect straight to success page ---
        if ($request->payment_method === 'cash') {
            return redirect()->route('order.success', $order->id);
        }

        // --- MIDTRANS (cashless): generate Snap token then redirect ---
        \Midtrans\Config::$serverKey = config('midtrans.server_key');
        \Midtrans\Config::$isProduction = config('midtrans.is_production');
        \Midtrans\Config::$isSanitized = config('midtrans.is_sanitized');
        \Midtrans\Config::$is3ds = config('midtrans.is_3ds');

        $itemDetails = [];
        foreach ($cart as $itemId => $cartItem) {
            $itemDetails[] = [
                'id' => (string) $itemId,
                'price' => (int) $cartItem['price'],
                'quantity' => (int) $cartItem['qty'],
                'name' => $cartItem['name'],
            ];
        }
        // Include tax as a line item
        $itemDetails[] = [
            'id' => 'TAX',
            'price' => $tax,
            'quantity' => 1,
            'name' => 'Pajak (10%)',
        ];

        $params = [
            'transaction_details' => [
                'order_id' => $order->order_number,
                'gross_amount' => $grandTotal,
            ],
            'customer_details' => [
                'first_name' => $request->customer_name,
                'phone' => $request->customer_phone ?? '',
            ],
            'item_details' => $itemDetails,
        ];

        $snapToken = \Midtrans\Snap::getSnapToken($params);

        return redirect()->route('order.success', $order->id)
            ->with('snap_token', $snapToken);
    }
}
