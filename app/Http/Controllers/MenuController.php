<?php

namespace App\Http\Controllers;

use App\Models\Item;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Session;

class MenuController extends Controller
{
    public function index(Request $request)
    {
        $tableNumber = $request->query('table_number');
        if ($tableNumber) {
            Session::put('table_number', $tableNumber);
        }

        $items = Item::where('is_available', true)->orderBy('name', 'asc')->get();
        return view('customer.menu', compact('items', 'tableNumber'));
    }

    public function cart()
    {
        $cart = Session::get('cart');
        $tableNumber = Session::get('table_number');
        return view('customer.cart', compact('cart', 'tableNumber'));
    }

    public function addToCart(Request $request)
    {
        $menuId = $request->input('menu_id') ?? $request->input('id');
        $menu = Item::find($menuId);

        if (!$menu) {
            return response()->json([
                'status' => 'error',
                'message' => 'Menu not found'
            ], 404);
        }

        $cart = Session::get('cart', []);

        if (isset($cart[$menuId])) {
            $cart[$menuId]['qty'] += 1;
        } else {
            $cart[$menuId] = [
                'id' => $menu->id,
                'name' => $menu->name,
                'price' => $menu->price,
                'image_path' => $menu->image_path,
                'qty' => 1
            ];
        }

        Session::put('cart', $cart);

        return response()->json([
            'status' => 'success',
            'message' => 'Menu added to cart',
            'cart_count' => array_sum(array_column($cart, 'qty'))
        ]);
    }

    public function updateCart(Request $request, $id)
    {
        $cart = Session::get('cart', []);

        if (isset($cart[$id])) {
            $qty = (int) $request->input('qty', 1);
            if ($qty <= 0) {
                unset($cart[$id]);
            } else {
                $cart[$id]['qty'] = $qty;
            }
            Session::put('cart', $cart);
        }

        return response()->json(['status' => 'success']);
    }

    public function removeFromCart($id)
    {
        $cart = Session::get('cart', []);
        unset($cart[$id]);
        Session::put('cart', $cart);

        return redirect()->route('cart')->with('success', 'Item berhasil dihapus dari keranjang.');
    }

    public function clearCart()
    {
        Session::forget('cart');
        return redirect()->route('cart')->with('success', 'Keranjang berhasil dikosongkan.');
    }
}
