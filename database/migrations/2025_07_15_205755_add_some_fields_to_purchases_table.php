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
        Schema::table('purchases', function (Blueprint $table) {
            $table->string('terms_of_payment')->nullable()->after('payment_status');
            $table->string('dispatched_through')->nullable()->after('terms_of_payment');
            $table->string('destination')->nullable()->after('dispatched_through');
            $table->text('terms_of_delivery')->nullable()->after('destination');
            $table->string('terms_of_price')->nullable()->after('terms_of_delivery');
            $table->string('packing_and_forwarding')->nullable()->after('terms_of_price');
            $table->string('freight_or_insurance')->nullable()->after('packing_and_forwarding');
            $table->string('other_charges')->nullable()->after('freight_or_insurance');
            $table->string('delivery')->nullable()->after('other_charges');
            $table->string('penalty')->nullable()->after('delivery');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('purchases', function (Blueprint $table) {
            $table->dropColumn([
                'terms_of_payment',
                'dispatched_through',
                'destination',
                'terms_of_delivery',
                'terms_of_price',
                'packing_and_forwarding',
                'freight_or_insurance',
                'other_charges',
                'delivery',
                'penalty'
            ]);
        });
    }
};
