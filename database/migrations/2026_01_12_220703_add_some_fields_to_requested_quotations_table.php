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
            $table->enum('priority', ['low', 'medium', 'high'])->nullable()->after('status');
            $table->date('expected_date')->nullable()->after('priority');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('requested_quotations', function (Blueprint $table) {
            $table->dropColumn('priority', 'expected_date');
        });
    }
};
