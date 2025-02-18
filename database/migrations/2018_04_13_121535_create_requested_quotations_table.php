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
        Schema::create('requested_quotations', function (Blueprint $table) {
            $table->id();
            $table->string('rfq_no')->unique();
            $table->enum('type', ['regular_mro', 'project', 'techtesla_stock'])->comment('Type of RFQ');
            $table->unsignedBigInteger('added_by')->nullable()->comment('User who added the RFQ'); // Make nullable
            $table->unsignedBigInteger('customer_id')->nullable()->comment('Customer associated with the RFQ');
            $table->date('date')->comment('Date of the RFQ');
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending')->comment('Status of the RFQ');
            $table->text('terms')->nullable()->comment('Terms and conditions');
            $table->text('delivery_info')->nullable()->comment('Delivery information');
            $table->text('note')->nullable();
            $table->timestamps();

            // Foreign keys
            $table->foreign('added_by')->references('id')->on('users')->onDelete('set null');
            $table->foreign('customer_id')->references('id')->on('customers')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('requested_quotations');
    }
};
