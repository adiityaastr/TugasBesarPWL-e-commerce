<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    /**
     * Display a listing of user's orders.
     */
    public function index()
    {
        $orders = Auth::user()->orders()->latest()->paginate(10);
        return view('orders.index', compact('orders'));
    }

    /**
     * Show Checkout Form
     */
    public function create()
    {
        $cartItems = \App\Models\Cart::with('product')->where('user_id', Auth::id())->get();
        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty.');
        }
        return view('checkout.index', compact('cartItems'));
    }
    
    /**
     * Store a newly created order from Cart/Checkout.
     */
    public function store(Request $request)
    {
        $request->validate([
            'shipping_address' => 'required|string',
            'payment_method' => 'required|in:bank_transfer,credit_card,cod', // Simulated
        ]);

        try {
            DB::beginTransaction();
            
            // Get Cart Items
            $cartItems = \App\Models\Cart::with('product')->where('user_id', Auth::id())->get();
            
            if ($cartItems->isEmpty()) {
                throw new \Exception("Cart is empty.");
            }

            $totalPrice = 0;
            $orderItemsData = [];

            foreach ($cartItems as $item) {
                $product = \App\Models\Product::lockForUpdate()->find($item->product_id);
                
                if ($product->stock < $item->quantity) {
                    throw new \Exception("Product {$product->name} is out of stock.");
                }

                $product->decrement('stock', $item->quantity);
                
                $price = $product->price * $item->quantity;
                $totalPrice += $price;

                $orderItemsData[] = [
                    'product_id' => $product->id,
                    'quantity' => $item->quantity,
                    'price' => $product->price,
                ];
            }

            $order = Order::create([
                'user_id' => Auth::id(),
                'total_price' => $totalPrice,
                'status' => 'pending',
                'shipping_address' => $request->shipping_address,
                'payment_method' => $request->payment_method,
                'payment_status' => 'paid', // Simulating successful payment
            ]);

            foreach ($orderItemsData as $data) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $data['product_id'],
                    'quantity' => $data['quantity'],
                    'price' => $data['price'],
                ]);
            }
            
            // Clear Cart
            \App\Models\Cart::where('user_id', Auth::id())->delete();

            DB::commit();

            return redirect()->route('orders.show', $order)->with('success', 'Order placed successfully! Invioce generated.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Order failed: ' . $e->getMessage());
        }
    }
    
    public function invoice(Order $order)
    {
        if ($order->user_id !== Auth::id() && Auth::user()->role !== 'admin') {
            abort(403);
        }
        return view('orders.invoice', compact('order'));
    }

    public function show(Order $order)
    {
        if ($order->user_id !== Auth::id()) {
            abort(403);
        }
        return view('orders.show', compact('order'));
    }
}
