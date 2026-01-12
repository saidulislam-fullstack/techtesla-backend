<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductPurchase extends Model
{
    protected $table = 'product_purchases';
    protected $fillable = [
        "rfq_item_id",
        "purchase_id",
        "product_id",
        "product_batch_id",
        "variant_id",
        "imei_number",
        "qty",
        "recieved",
        "purchase_unit_id",
        "net_unit_cost",
        "discount",
        "tax_rate",
        "tax",
        "total",
        "supplier_currency_id",
        "currency_rate",
        "supplier_price",
    ];

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    public function variant()
    {
        return $this->belongsTo(ProductVariant::class, 'variant_id');
    }

    public function purchase()
    {
        return $this->belongsTo(Purchase::class, 'purchase_id');
    }

    public function unit()
    {
        return $this->belongsTo(Unit::class, 'purchase_unit_id');
    }

    public function rfqItem()
    {
        return $this->belongsTo(RequestedQuotationDetail::class, 'rfq_item_id');
    }
}
