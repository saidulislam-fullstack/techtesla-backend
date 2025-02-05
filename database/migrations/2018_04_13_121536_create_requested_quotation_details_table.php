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
        Schema::create('requested_quotation_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('requested_quotation_id')->comment('Requested quotation ID');
            $table->string('product_code')->comment('Product Code');
            $table->unsignedBigInteger('product_id')->comment('Product ID');
            $table->integer('quantity')->comment('Quantity of the product');
            $table->decimal('proposed_price', 10, 2)->nullable()->comment('Proposed price of the product');
            $table->timestamps();
            $table->foreign('requested_quotation_id')->references('id')->on('requested_quotations')->onDelete('cascade');
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('requested_quotation_details');
    }
};
