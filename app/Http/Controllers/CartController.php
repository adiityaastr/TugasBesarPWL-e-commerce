<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function index()
    {
        if (Auth::user()?->role === 'admin') {
            return redirect()->route('admin.dashboard')->with('error', 'Admin tidak dapat melakukan pembelian.');
        }
        $cartItems = Cart::with('product')->where('user_id', Auth::id())->get();
        return view('cart.index', compact('cartItems'));
    }

    public function store(Request $request)
    {
        if (Auth::user()?->role === 'admin') {
            return redirect()->route('admin.dashboard')->with('error', 'Admin tidak dapat melakukan pembelian.');
        }
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
            'redirect_to' => 'nullable|in:checkout',
        ]);

        $product = Product::find($request->product_id);

        if (!$product) {
            return back()->with('error', 'Product not found.');
        }

        if ($product->stock < $request->quantity) {
             return back()->with('error', 'Product out of stock or insufficient quantity.');
        }

        $cartItem = Cart::where('user_id', Auth::id())
                        ->where('product_id', $request->product_id)
                        ->first();

        if ($cartItem) {
            $cartItem->quantity += $request->quantity;
            $cartItem->save();
        } else {
            Cart::create([
                'user_id' => Auth::id(),
                'product_id' => $request->product_id,
                'quantity' => $request->quantity,
            ]);
        }

        $cartCount = Cart::where('user_id', Auth::id())->sum('quantity');

        if ($request->redirect_to === 'checkout') {
            return redirect()->route('checkout.index');
        }

        if ($request->wantsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Produk telah ditambahkan ke keranjang.',
                'cartCount' => $cartCount,
            ]);
        }

        return back()->with('success', 'Produk telah ditambahkan ke keranjang.');
    }

    public function update(Request $request, Cart $cart)
    {
        if (Auth::user()?->role === 'admin') {
            return redirect()->route('admin.dashboard')->with('error', 'Admin tidak dapat melakukan pembelian.');
        }
        if ($cart->user_id !== Auth::id()) abort(403);
        
        $request->validate(['quantity' => 'required|integer|min:1']);
        
        if ($cart->product->stock < $request->quantity) {
             return back()->with('error', 'Insufficient stock.');
        }

        $cart->update(['quantity' => $request->quantity]);

        return back()->with('success', 'Cart updated.');
    }

    public function destroy(Cart $cart)
    {
        if (Auth::user()?->role === 'admin') {
            return redirect()->route('admin.dashboard')->with('error', 'Admin tidak dapat melakukan pembelian.');
        }
        if ($cart->user_id !== Auth::id()) abort(403);
        $cart->delete();
        return back()->with('success', 'Item removed from cart.');
    }
}
