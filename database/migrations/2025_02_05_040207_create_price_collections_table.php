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
        Schema::create('price_collections', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('product_id');
            $table->unsignedBigInteger('rfq_id');
            $table->unsignedBigInteger('rfq_item_id');
            $table->unsignedBigInteger('supplier_id');
            $table->unsignedBigInteger('currency_id');
            $table->decimal('price', 10, 2);
            $table->string('note')->nullable();
            $table->decimal('currency_rate', 4, 2)->default(1);
            $table->decimal('shipping_weight', 10, 2)->default(0);
            $table->decimal('customs_unit_cost', 10, 2)->default(0);
            $table->decimal('customs_total_cost', 10, 2)->default(0);
            $table->decimal('profit_margin_percentage', 10, 2)->default(0);
            $table->decimal('profit_margin_amount', 10, 2)->default(0);
            $table->decimal('tax_amount', 10, 2)->default(0);
            $table->decimal('vat_amount', 10, 2)->default(0);
            $table->decimal('other_cost', 10, 2)->default(0);
            $table->decimal('total_cost', 10, 2)->default(0);
            $table->string('origin')->nullable();
            $table->decimal('delivery_days', 10, 2)->default(0);
            $table->boolean('is_selected')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('price_collections');
    }
};
