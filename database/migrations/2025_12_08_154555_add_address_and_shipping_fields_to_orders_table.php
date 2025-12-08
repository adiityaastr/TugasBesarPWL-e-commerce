<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->string('provinsi')->nullable()->after('shipping_address');
            $table->string('kota')->nullable()->after('provinsi');
            $table->string('kecamatan')->nullable()->after('kota');
            $table->string('kelurahan')->nullable()->after('kecamatan');
            $table->string('kode_pos')->nullable()->after('kelurahan');
            $table->string('shipping_method')->nullable()->after('kode_pos');
            $table->decimal('shipping_cost', 10, 2)->default(0)->after('shipping_method');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn([
                'provinsi',
                'kota',
                'kecamatan',
                'kelurahan',
                'kode_pos',
                'shipping_method',
                'shipping_cost',
            ]);
        });
    }
};
