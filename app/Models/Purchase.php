<?php

namespace App\Models;

use App\Models\Currency;
use App\Models\Supplier;
use App\Models\Warehouse;
use Illuminate\Database\Eloquent\Model;

class Purchase extends Model
{
    protected $fillable = [
        "reference_no",
        "user_id",
        "warehouse_id",
        "rfq_id",
        "supplier_id",
        "currency_id",
        "exchange_rate",
        "item",
        "total_qty",
        "total_discount",
        "total_tax",
        "total_cost",
        "order_tax_rate",
        "order_tax",
        "order_discount",
        "shipping_cost",
        "grand_total",
        "paid_amount",
        "status",
        "payment_status",
        "terms_of_payment",
        "dispatched_through",
        "destination",
        "p_and_f",
        "price_basis",
        "packing_and_forwarding",
        "freight_or_insurance",
        "other_charges",
        "delivery",
        "penalty",
        "document",
        "note",
        "created_at"
    ];

    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }

    public function warehouse()
    {
        return $this->belongsTo(Warehouse::class);
    }

    public function currency()
    {
        return $this->belongsTo(Currency::class);
    }

    public function rfq()
    {
        return $this->belongsTo(RequestedQuotation::class, 'rfq_id');
    }

    public function items()
    {
        return $this->hasMany(ProductPurchase::class, 'purchase_id', 'id');
    }
}
