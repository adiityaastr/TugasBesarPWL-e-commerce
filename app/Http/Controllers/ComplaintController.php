<?php

namespace App\Http\Controllers;

use App\Models\Complaint;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ComplaintController extends Controller
{
    /**
     * Store a new complaint from customer
     */
    public function store(Request $request, Order $order)
    {
        if ($order->user_id !== Auth::id()) {
            abort(403);
        }

        if ($order->status !== 'selesai') {
            return back()->with('error', 'Komplain hanya dapat diajukan untuk pesanan yang sudah selesai.');
        }

        $request->validate([
            'complaint_title' => 'required|string|max:255',
            'complaint_detail' => 'required|string|max:2000',
            'complaint_image' => 'nullable|image|max:2048',
        ]);

        $imagePath = null;
        if ($request->hasFile('complaint_image')) {
            $imagePath = $request->file('complaint_image')->store('complaint-images', 'public');
        }

        Complaint::create([
            'order_id' => $order->id,
            'user_id' => Auth::id(),
            'title' => $request->complaint_title,
            'detail' => $request->complaint_detail,
            'image_path' => $imagePath,
            'status' => 'pending',
        ]);

        return redirect()->route('orders.show', $order)->with('success', 'Komplain berhasil diajukan. Tim kami akan segera meninjau komplain Anda.');
    }

    /**
     * Admin: View all complaints
     */
    public function index()
    {
        $complaints = Complaint::with(['order', 'user'])
            ->latest()
            ->paginate(15);
        
        return view('admin.complaints.index', compact('complaints'));
    }

    /**
     * Admin: View single complaint
     */
    public function show(Complaint $complaint)
    {
        $complaint->load(['order.items.product', 'user']);
        return view('admin.complaints.show', compact('complaint'));
    }

    /**
     * Admin: Update complaint status
     */
    public function updateStatus(Request $request, Complaint $complaint)
    {
        $request->validate([
            'status' => 'required|in:pending,in_progress,resolved,rejected',
            'admin_response' => 'nullable|string|max:2000',
        ]);

        $complaint->update([
            'status' => $request->status,
            'admin_response' => $request->admin_response,
        ]);

        return back()->with('success', 'Status komplain berhasil diperbarui.');
    }
}
