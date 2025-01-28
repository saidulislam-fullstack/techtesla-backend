<?php

namespace App\Models;

use App\Models\User;
use App\Models\Customer;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class RequestedQuotation extends Model
{
    use HasFactory;

    protected $fillable = [
        'reference_no',
        'type',
        'added_by',
        'customer_id',
        'date',
        'status',
        'terms',
        'delivery_info',
        'document',
        'note',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->reference_no = 'RFQ-' . date('YmdHis');
            $model->added_by = auth()->id();
        });
    }

    public function addedBy()
    {
        return $this->belongsTo(User::class, 'added_by');
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }
}
