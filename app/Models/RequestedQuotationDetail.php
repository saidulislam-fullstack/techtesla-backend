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
        'quantity',
        'price',
        'proposed_price',
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
