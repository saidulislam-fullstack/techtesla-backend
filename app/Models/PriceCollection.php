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
        'price',
        'note',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
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
