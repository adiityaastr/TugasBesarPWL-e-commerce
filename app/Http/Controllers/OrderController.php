<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class OrderController extends Controller
{
    /**
     * Display a listing of user's orders.
     */
    public function index()
    {
        if (Auth::user()?->role === 'admin') {
            return redirect()->route('admin.dashboard')->with('error', 'Admin tidak dapat melakukan pembelian.');
        }
        /** @var \App\Models\User $user */
        $user = Auth::user();
        $orders = $user->orders()->latest()->paginate(10);
        return view('orders.index', compact('orders'));
    }

    /**
     * Show Checkout Form
     */
    public function create()
    {
        if (Auth::user()?->role === 'admin') {
            return redirect()->route('admin.dashboard')->with('error', 'Admin tidak dapat melakukan pembelian.');
        }
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
        if (Auth::user()?->role === 'admin') {
            return redirect()->route('admin.dashboard')->with('error', 'Admin tidak dapat melakukan pembelian.');
        }
        $request->validate([
            'shipping_address' => 'required|string',
            'provinsi' => 'nullable|string|max:255',
            'kota' => 'nullable|string|max:255',
            'kecamatan' => 'nullable|string|max:255',
            'kelurahan' => 'nullable|string|max:255',
            'kode_pos' => 'nullable|string|max:10',
            'shipping_method' => 'required|in:reguler,kargo,same_day',
            'payment_method' => 'required|in:bank_transfer,credit_card,cod', // Simulated
        ]);

        // Hitung shipping cost berdasarkan metode pengiriman
        $shippingCosts = [
            'reguler' => 15000,
            'kargo' => 10000,
            'same_day' => 30000,
        ];
        $shippingCost = $shippingCosts[$request->shipping_method] ?? 15000;

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
                
                if (!$product) {
                    throw new \Exception("Product with ID {$item->product_id} not found. It may have been deleted.");
                }
                
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

            // Total price termasuk shipping cost
            $finalTotalPrice = $totalPrice + $shippingCost;

            $order = Order::create([
                'user_id' => Auth::id(),
                'order_number' => $this->generateOrderNumber(),
                'total_price' => $finalTotalPrice,
                'status' => 'proses',
                'payment_status' => 'pending',
                'shipping_address' => $request->shipping_address,
                'provinsi' => $request->provinsi ?? null,
                'kota' => $request->kota ?? null,
                'kecamatan' => $request->kecamatan ?? null,
                'kelurahan' => $request->kelurahan ?? null,
                'kode_pos' => $request->kode_pos ?? null,
                'shipping_method' => $request->shipping_method,
                'shipping_cost' => $shippingCost,
                'payment_method' => $request->payment_method,
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

    /**
     * Customer confirms order completed.
     */
    public function complete(Request $request, Order $order)
    {
        if ($order->user_id !== Auth::id()) {
            abort(403);
        }

        if (!in_array($order->status, ['pengiriman', 'sudah_sampai'])) {
            return back()->with('error', 'Pesanan belum dapat diselesaikan.');
        }

        $request->validate([
            'reviews' => 'nullable|array',
            'reviews.*.product_id' => 'required|exists:products,id',
            'reviews.*.rating' => 'required|integer|min:1|max:5',
            'reviews.*.comment' => 'nullable|string',
            'reviews.*.image' => 'nullable|image|max:2048',
        ]);

        DB::transaction(function () use ($order, $request) {
            if ($request->has('reviews')) {
                foreach ($request->reviews as $reviewData) {
                    $imagePath = null;
                    if (isset($reviewData['image']) && $reviewData['image'] instanceof \Illuminate\Http\UploadedFile) {
                        $imagePath = $reviewData['image']->store('review-images', 'public');
                    }

                    \App\Models\Review::create([
                        'user_id' => Auth::id(),
                        'product_id' => $reviewData['product_id'],
                        'order_id' => $order->id,
                        'rating' => $reviewData['rating'],
                        'comment' => $reviewData['comment'] ?? null,
                        'image_path' => $imagePath,
                    ]);
                }
            }

            $order->update([
                'status' => 'selesai',
                'payment_status' => 'released',
            ]);
        });

        return back()->with('success', 'Pesanan telah diselesaikan dan ulasan berhasil dikirim. Terima kasih!');
    }

    private function generateOrderNumber(): string
    {
        do {
            $code = 'HM-' . Str::upper(Str::random(10));
        } while (Order::where('order_number', $code)->exists());

        return $code;
    }
}
