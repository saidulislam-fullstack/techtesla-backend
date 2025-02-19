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
        'rfq_no',
        'type',
        'added_by',
        'customer_id',
        'date',
        'status',
        'terms',
        'delivery_info',
        'note',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
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

    public function items()
    {
        return $this->hasMany(RequestedQuotationDetail::class);
    }

    public function priceCollection()
    {
        return $this->hasMany(PriceCollection::class, 'rfq_id');
    }

    public function documents()
    {
        return $this->hasMany(RequestedQuotationAttachment::class);
    }

    public function getHasPriceCollectionSelectedAttribute()
    {
        return $this->priceCollection()->where('is_selected', true)->exists();
    }
}
