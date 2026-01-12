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
        Schema::table('product_purchases', function (Blueprint $table) {
            $table->unsignedInteger('supplier_currency_id')->nullable()->after('net_unit_cost');
            $table->decimal('currency_rate')->default(1)->after('supplier_currency_id');
            $table->decimal('supplier_price')->nullable()->after('currency_rate');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('product_purchases', function (Blueprint $table) {
            $table->dropColumn(['supplier_currency_id', 'currency_rate', 'supplier_price']);
        });
    }
};
