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
        Schema::table('sales', function (Blueprint $table) {
            $table->string('po_number')->nullable()->after('staff_note');
            $table->timestamp('po_date')->nullable()->after('po_number');
            $table->timestamp('invoice_date')->nullable()->after('po_date');
            $table->timestamp('delivery_date')->nullable()->after('invoice_date');
            $table->timestamp('vat_chalan_date')->nullable()->after('delivery_date');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('sales', function (Blueprint $table) {
            $table->dropColumn([
                'po_number',
                'po_date',
                'invoice_date',
                'delivery_date',
                'vat_chalan_date',
            ]);
        });
    }
};
