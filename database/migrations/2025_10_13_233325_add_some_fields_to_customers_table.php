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
        Schema::table('customers', function (Blueprint $table) {
            $table->string('bin_number')->nullable()->after('tax_no');
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
        Schema::table('customers', function (Blueprint $table) {
            $table->dropColumn('bin_number');
            $table->string('name')->change();
            $table->string('phone_number')->change();
            $table->string('city')->change();
        });
    }
};
