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
        Schema::table('requested_quotations', function (Blueprint $table) {
            $table->decimal('vat_percentage', 5, 2)->nullable()->after('note');
            $table->decimal('vat_amount', 5, 2)->nullable()->after('vat_percentage');
            $table->text('payment_term')->nullable()->after('vat_amount');
            $table->string('price_validity')->nullable()->after('payment_term');
            $table->text('warranty')->nullable()->after('price_validity');
            $table->string('suspension_of_installation')->nullable()->after('warranty');
            $table->string('commissioning')->nullable()->after('suspension_of_installation');
            $table->string('mechanical_works')->nullable()->after('commissioning');
            $table->string('cable_laying')->nullable()->after('mechanical_works');
            $table->string('vat')->nullable()->after('cable_laying');
            $table->string('tax')->nullable()->after('vat');
            $table->string('transport')->nullable()->after('tax');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('requested_quotations', function (Blueprint $table) {
            $table->dropColumn([
                'vat_percentage',
                'vat_amount',
                'payment_term',
                'price_validity',
                'warranty',
                'suspension_of_installation',
                'commissioning',
                'mechanical_works',
                'cable_laying',
                'vat',
                'tax',
                'transport',
            ]);
        });
    }
};
