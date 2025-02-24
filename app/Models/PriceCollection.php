<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PriceCollection extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'rfq_id',
        'rfq_item_id',
        'supplier_id',
        'currency_id',
        'price',
        'note',
        'currency_rate',
        'shipping_weight',
        'customs_unit_cost',
        'customs_total_cost',
        'profit_margin_percentage',
        'profit_margin_amount',
        'tax_amount',
        'vat_amount',
        'other_cost',
        'total_cost',
        'origin',
        'delivery_days',
        'is_selected',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function currency()
    {
        return $this->belongsTo(Currency::class);
    }

    public function rfq()
    {
        return $this->belongsTo(RequestedQuotation::class);
    }

    public function rfqItem()
    {
        return $this->belongsTo(RequestedQuotationDetail::class);
    }

    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }
}
