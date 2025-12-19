<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderCancelController extends Controller
{
    public function __invoke(Request $request, Order $order)
    {
        // Pastikan hanya pemilik order yang bisa membatalkan
        if ($order->user_id !== Auth::id()) {
            abort(403);
        }

        if ($order->status === 'cancelled') {
            return back()->with('error', 'Pesanan sudah dibatalkan.');
        }

        if ($order->status === 'pending_cancellation') {
            return back()->with('error', 'Pembatalan sudah diajukan, menunggu konfirmasi penjual.');
        }

        if ($order->status === 'selesai') {
            return back()->with('error', 'Pesanan sudah selesai dan tidak dapat dibatalkan. Jika ada masalah, silakan ajukan komplain.');
        }

        $request->validate([
            'cancellation_reason' => 'required|string|max:500',
        ]);

        $order->update([
            'status' => 'pending_cancellation',
            'cancellation_reason' => $request->cancellation_reason,
        ]);

        return redirect()->route('orders.show', $order)->with('success', 'Pembatalan berhasil diajukan. Menunggu konfirmasi penjual.');
    }
}

