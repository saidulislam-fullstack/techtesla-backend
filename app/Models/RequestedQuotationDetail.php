<?php

namespace App\Models;

use App\Models\Product;
use App\Models\RequestedQuotation;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class RequestedQuotationDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'requested_quotation_id',
        'product_id',
        'product_code',
        'quantity',
        'proposed_price',
        'note',
    ];

    public function requestedQuotation()
    {
        return $this->belongsTo(RequestedQuotation::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
