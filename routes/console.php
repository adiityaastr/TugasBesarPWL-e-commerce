<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;
use App\Models\Order;
use Carbon\Carbon;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

// Jadwal auto-release: jika status sudah_sampai > 3 hari, set selesai & release pembayaran
Schedule::call(function () {
    $cutoff = Carbon::now()->subDays(3);
    Order::where('status', 'sudah_sampai')
        ->where('updated_at', '<=', $cutoff)
        ->where('payment_status', '!=', 'released')
        ->update([
            'status' => 'selesai',
            'payment_status' => 'released',
        ]);
})->daily();
