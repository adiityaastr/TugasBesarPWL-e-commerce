<?php

namespace App\Http\Controllers;

use App\Models\Address;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AddressController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'recipient_name' => 'required|string|max:255',
            'shipping_address' => 'required|string',
            'provinsi' => 'nullable|string|max:255',
            'kota' => 'nullable|string|max:255',
            'kecamatan' => 'nullable|string|max:255',
            'kelurahan' => 'nullable|string|max:255',
            'kode_pos' => 'nullable|string|max:10',
            'is_default' => 'nullable|boolean',
        ]);

        DB::transaction(function () use ($request) {
            // Jika ini adalah alamat default, set semua alamat lain menjadi non-default
            if ($request->is_default) {
                Address::where('user_id', Auth::id())
                    ->update(['is_default' => false]);
            }

            Address::create([
                'user_id' => Auth::id(),
                'recipient_name' => $request->recipient_name,
                'shipping_address' => $request->shipping_address,
                'provinsi' => $request->provinsi,
                'kota' => $request->kota,
                'kecamatan' => $request->kecamatan,
                'kelurahan' => $request->kelurahan,
                'kode_pos' => $request->kode_pos,
                'is_default' => $request->is_default ?? false,
            ]);
        });

        return back()->with('success', 'Alamat berhasil disimpan.');
    }

    public function update(Request $request, Address $address)
    {
        if ($address->user_id !== Auth::id()) {
            abort(403);
        }

        $request->validate([
            'recipient_name' => 'required|string|max:255',
            'shipping_address' => 'required|string',
            'provinsi' => 'nullable|string|max:255',
            'kota' => 'nullable|string|max:255',
            'kecamatan' => 'nullable|string|max:255',
            'kelurahan' => 'nullable|string|max:255',
            'kode_pos' => 'nullable|string|max:10',
            'is_default' => 'nullable|boolean',
        ]);

        DB::transaction(function () use ($request, $address) {
            // Jika ini adalah alamat default, set semua alamat lain menjadi non-default
            if ($request->is_default) {
                Address::where('user_id', Auth::id())
                    ->where('id', '!=', $address->id)
                    ->update(['is_default' => false]);
            }

            $address->update([
                'recipient_name' => $request->recipient_name,
                'shipping_address' => $request->shipping_address,
                'provinsi' => $request->provinsi,
                'kota' => $request->kota,
                'kecamatan' => $request->kecamatan,
                'kelurahan' => $request->kelurahan,
                'kode_pos' => $request->kode_pos,
                'is_default' => $request->is_default ?? false,
            ]);
        });

        if ($request->wantsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Alamat berhasil diperbarui.',
            ]);
        }

        return back()->with('success', 'Alamat berhasil diperbarui.');
    }

    public function destroy(Request $request, Address $address)
    {
        if ($address->user_id !== Auth::id()) {
            abort(403);
        }

        $address->delete();

        if ($request->wantsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Alamat berhasil dihapus.',
            ]);
        }

        return back()->with('success', 'Alamat berhasil dihapus.');
    }

    public function setDefault(Address $address)
    {
        if ($address->user_id !== Auth::id()) {
            abort(403);
        }

        DB::transaction(function () use ($address) {
            Address::where('user_id', Auth::id())
                ->update(['is_default' => false]);
            
            $address->update(['is_default' => true]);
        });

        return back()->with('success', 'Alamat default berhasil diubah.');
    }
}
