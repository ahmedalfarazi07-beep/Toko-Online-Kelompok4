<?php

namespace App\Http\Controllers;

use App\Models\CartItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class CartController extends Controller
{
    public function index()
    {
        $cartItems = Auth::check()
            ? CartItem::with('product')->where('user_id', Auth::id())->get()
            : CartItem::with('product')->where('session_id', Session::getId())->get();

        $total = $cartItems->sum(fn ($item) => ($item->product->discount_price ?? $item->product->price) * $item->quantity);

        return view('cart.index', compact('cartItems', 'total'));
    }

    public function add(Request $request)
    {
        $validated = $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
        ]);

        $product = Product::findOrFail($validated['product_id']);

        if ($product->stock < 1) {
            return redirect()->back()->with('error', __('Produk sedang habis.'));
        }

        $validated['quantity'] = min($validated['quantity'], $product->stock);

        $sessionId = Session::getId();
        $userId = Auth::check() ? Auth::id() : null;

        $cartItem = CartItem::where('product_id', $product->id)
            ->where(function ($q) use ($userId, $sessionId) {
                $q->where('session_id', $sessionId);
                if ($userId) {
                    $q->orWhere('user_id', $userId);
                }
            })
            ->first();

        if ($cartItem) {
            $cartItem->increment('quantity', $validated['quantity']);
        } else {
            CartItem::create([
                'user_id' => $userId,
                'session_id' => $sessionId,
                'product_id' => $product->id,
                'quantity' => $validated['quantity'],
            ]);
        }

        return redirect()->back()->with('success', __('Produk berhasil ditambahkan ke keranjang.'));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'quantity' => 'required|integer|min:1|max:99',
        ]);

        $cartItem = $this->resolveCartItem($id);
        $cartItem->update(['quantity' => $validated['quantity']]);

        return redirect()->back()->with('success', __('Jumlah produk berhasil diperbarui.'));
    }

    public function remove($id)
    {
        $cartItem = $this->resolveCartItem($id);
        $cartItem->delete();

        return redirect()->back()->with('success', __('Produk berhasil dihapus dari keranjang.'));
    }

    private function resolveCartItem($id)
    {
        $query = CartItem::where('id', $id);

        if (Auth::check()) {
            $query->where('user_id', Auth::id());
        } else {
            $query->where('session_id', Session::getId());
        }

        return $query->firstOrFail();
    }
}
