<?php

namespace App\Http\Controllers;

use App\Models\CartItem;
use App\Models\Order;
use App\Models\OrderStatus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class OrderController extends Controller
{
    public function checkout()
    {
        $cartItems = Auth::check()
            ? CartItem::with('product')->where('user_id', Auth::id())->get()
            : CartItem::with('product')->where('session_id', Session::getId())->get();

        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.index')->with('error', __('Keranjang belanja Anda kosong.'));
        }

        $total = $cartItems->sum(fn ($item) => ($item->product->discount_price ?? $item->product->price) * $item->quantity);

        return view('checkout.index', compact('cartItems', 'total'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'address' => 'required|string|max:500',
            'city' => 'required|string|max:100',
            'province' => 'required|string|max:100',
            'postal_code' => 'required|string|max:20',
            'payment_method' => 'required|string|in:transfer,credit_card,cod',
        ]);

        $cartItems = Auth::check()
            ? CartItem::with('product')->where('user_id', Auth::id())->get()
            : CartItem::with('product')->where('session_id', Session::getId())->get();

        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.index')->with('error', __('Keranjang belanja Anda kosong.'));
        }

        // Check stock availability
        foreach ($cartItems as $cartItem) {
            if ($cartItem->product->stock < $cartItem->quantity) {
                return redirect()->route('cart.index')->with('error', __('Stok :name tidak mencukupi.', ['name' => $cartItem->product->name]));
            }
        }

        $order = DB::transaction(function () use ($cartItems, $validated) {
            $total = $cartItems->sum(fn ($item) => ($item->product->discount_price ?? $item->product->price) * $item->quantity);

            $order = Order::create([
                'user_id' => Auth::check() ? Auth::id() : null,
                'status' => 'pending',
                'total' => $total,
                'shipping_address' => $validated['address'],
                'shipping_city' => $validated['city'],
                'shipping_province' => $validated['province'],
                'shipping_postal_code' => $validated['postal_code'],
                'payment_method' => $validated['payment_method'],
            ]);

            foreach ($cartItems as $cartItem) {
                $order->orderItems()->create([
                    'product_id' => $cartItem->product_id,
                    'name' => $cartItem->product->name,
                    'price' => $cartItem->product->discount_price ?? $cartItem->product->price,
                    'quantity' => $cartItem->quantity,
                ]);

                $cartItem->product->decrement('stock', $cartItem->quantity);
            }

            OrderStatus::create([
                'order_id' => $order->id,
                'name' => 'pending',
            ]);

            $cartItems->each->delete();

            return $order;
        });

        return redirect()->route('orders.show', $order)->with('success', __('Pesanan berhasil dibuat.'));
    }

    public function index()
    {
        $orders = Order::with('orderItems')
            ->where('user_id', Auth::id())
            ->latest()
            ->paginate(10);

        return view('orders.index', compact('orders'));
    }

    public function show($id)
    {
        $order = Order::with('orderItems.product')
            ->where('user_id', Auth::id())
            ->findOrFail($id);

        return view('orders.show', compact('order'));
    }

    public function userDashboard()
    {
        $orders = Order::with('items')
            ->where('user_id', Auth::id())
            ->latest()
            ->get();

        $reviews = Auth::user()->reviews()
            ->with('product')
            ->latest()
            ->get();

        return view('dashboard', compact('orders', 'reviews'));
    }
}
