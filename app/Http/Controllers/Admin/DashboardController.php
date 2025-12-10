<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $totalOrders = Order::count();
        $totalProducts = Product::count();
        $totalUsers = User::where('role', 'customer')->count();
        $recentOrders = Order::with('user')->latest()->take(5)->get();

        // Data untuk grafik pendapatan per bulan (6 bulan terakhir)
        $monthlyRevenue = Order::selectRaw('DATE_FORMAT(created_at, "%Y-%m") as month, SUM(total_price) as revenue')
            ->where('created_at', '>=', now()->subMonths(6))
            ->where('status', 'selesai')
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        $revenueLabels = $monthlyRevenue->pluck('month')->map(function($month) {
            return date('M Y', strtotime($month . '-01'));
        })->toArray();
        $revenueData = $monthlyRevenue->pluck('revenue')->toArray();

        // Data untuk grafik produk terlaris (top 5)
        $topProducts = \App\Models\OrderItem::selectRaw('order_items.product_id, SUM(order_items.quantity) as total_sold')
            ->join('orders', 'order_items.order_id', '=', 'orders.id')
            ->where('orders.status', 'selesai')
            ->groupBy('order_items.product_id')
            ->orderByDesc('total_sold')
            ->take(5)
            ->get();

        $productIds = $topProducts->pluck('product_id')->toArray();
        $products = Product::whereIn('id', $productIds)->get()->keyBy('id');
        
        $productLabels = $topProducts->map(function($item) use ($products) {
            return $products->get($item->product_id)?->name ?? 'Unknown';
        })->toArray();
        $productData = $topProducts->pluck('total_sold')->toArray();

        // Data untuk grafik status pesanan
        $orderStatuses = Order::selectRaw('status, COUNT(*) as count')
            ->groupBy('status')
            ->get();

        $statusLabels = $orderStatuses->pluck('status')->map(function($status) {
            return ucfirst(str_replace('_', ' ', $status));
        })->toArray();
        $statusData = $orderStatuses->pluck('count')->toArray();

        // Total pendapatan (hanya pesanan selesai)
        $totalRevenue = Order::where('status', 'selesai')->sum('total_price');

        return view('admin.dashboard', compact(
            'totalOrders', 
            'totalProducts', 
            'totalUsers', 
            'recentOrders',
            'revenueLabels',
            'revenueData',
            'productLabels',
            'productData',
            'statusLabels',
            'statusData',
            'totalRevenue'
        ));
    }
    
    public function orders()
    {
        $orders = Order::with('user')->latest()->paginate(10);
        return view('admin.orders.index', compact('orders'));
    }

    public function label(Order $order)
    {
        // Admin only (middleware already applied)
        $order->load(['user', 'items.product']);
        return view('admin.orders.label', compact('order'));
    }

    public function updateOrderStatus(Request $request, Order $order)
    {
        $request->validate([
            'status' => 'required|in:proses,pengemasan,pengiriman,sudah_sampai,selesai,cancelled',
        ]);

        // Jika sudah selesai/released, tidak bisa diubah lagi
        if ($order->status === 'selesai' || $order->payment_status === 'released') {
            return back()->with('error', 'Pesanan sudah selesai dan tidak dapat diubah lagi.');
        }

        // Jika status cancelled dipilih, pastikan ada pending_cancellation
        if ($request->status === 'cancelled') {
            if ($order->status !== 'pending_cancellation') {
                return back()->with('error', 'Pembatalan hanya bisa dilakukan jika pembeli sudah mengajukan pembatalan.');
            }
            
            // Restore stock
            foreach ($order->items as $item) {
                $product = $item->product;
                if ($product) {
                    $product->increment('stock', $item->quantity);
                }
            }
        }

        $order->update(['status' => $request->status]);

        // Jika status selesai, release pembayaran
        if ($request->status === 'selesai') {
            $order->update(['payment_status' => 'released']);
        }

        return back()->with('success', 'Status pesanan berhasil diperbarui.');
    }

    public function approveCancellation(Request $request, Order $order)
    {
        if ($order->status !== 'pending_cancellation') {
            return back()->with('error', 'Pesanan ini tidak memiliki permintaan pembatalan.');
        }

        // Restore stock
        foreach ($order->items as $item) {
            $product = $item->product;
            if ($product) {
                $product->increment('stock', $item->quantity);
            }
        }

        $order->update(['status' => 'cancelled']);

        return back()->with('success', 'Pembatalan pesanan telah disetujui dan stok produk telah dikembalikan.');
    }

    public function rejectCancellation(Request $request, Order $order)
    {
        if ($order->status !== 'pending_cancellation') {
            return back()->with('error', 'Pesanan ini tidak memiliki permintaan pembatalan.');
        }

        // Kembalikan ke status sebelumnya atau default ke 'proses'
        $order->update([
            'status' => 'proses',
            'cancellation_reason' => null,
        ]);

        return back()->with('success', 'Pembatalan pesanan telah ditolak. Pesanan dikembalikan ke status proses.');
    }

    public function reports(Request $request)
    {
        $query = Order::with(['user', 'items.product']);

        // Filter berdasarkan tanggal mulai
        if ($request->filled('start_date')) {
            $query->whereDate('created_at', '>=', $request->start_date);
        }

        // Filter berdasarkan tanggal akhir
        if ($request->filled('end_date')) {
            $query->whereDate('created_at', '<=', $request->end_date);
        }

        // Filter berdasarkan status
        if ($request->filled('status') && $request->status !== 'all') {
            $query->where('status', $request->status);
        }

        $orders = $query->latest()->get();

        // Hitung statistik
        $totalOrders = $orders->count();
        $totalCancelled = $orders->where('status', 'cancelled')->count();
        // Pesanan yang sudah dikirim (belum tentu selesai, tapi sudah dalam proses pengiriman)
        $totalShipped = $orders->where('status', 'pengiriman')->count();
        // Pendapatan hanya dari pesanan selesai
        $totalRevenue = $orders->where('status', 'selesai')->sum('total_price');

        return view('admin.reports.index', compact('orders', 'totalOrders', 'totalRevenue', 'totalCancelled', 'totalShipped'));
    }
}
