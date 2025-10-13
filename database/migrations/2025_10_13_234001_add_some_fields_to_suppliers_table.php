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
        Schema::table('suppliers', function (Blueprint $table) {
            $table->string('supplier_type')->nullable()->after('name');
            $table->string('company_specialization')->nullable()->after('company_name');
            $table->string('products_and_services')->nullable()->after('company_specialization');
            $table->string('distributionship_or_agency')->nullable()->after('products_and_services');
            $table->string('name')->nullable()->change();
            $table->string('phone_number')->nullable()->change();
            $table->string('city')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('suppliers', function (Blueprint $table) {
            $table->dropColumn('supplier_type');
            $table->dropColumn('company_specialization');
            $table->dropColumn('products_and_services');
            $table->dropColumn('distributionship_or_agency');
            $table->string('name')->change();
            $table->string('phone_number')->change();
            $table->string('city')->change();
        });
    }
};
