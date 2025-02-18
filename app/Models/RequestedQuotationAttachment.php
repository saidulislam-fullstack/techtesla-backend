<?php

namespace App\Models;

use App\Models\RequestedQuotation;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class RequestedQuotationAttachment extends Model
{
    use HasFactory;

    protected $fillable = ['requested_quotation_id', 'file_path'];

    public function requestedQuotation()
    {
        return $this->belongsTo(RequestedQuotation::class);
    }
}
