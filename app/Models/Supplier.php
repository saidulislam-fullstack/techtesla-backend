<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    protected $fillable = [

        "name",
        "image",
        "company_name",
        "vat_number",
        "email",
        "phone_number",
        "address",
        "city",
        "state",
        "postal_code",
        "country",
        "is_active",
        'supplier_type',
        'company_specialization',
        'products_and_services',
        'distributionship_or_agency',

    ];

    public function product()
    {
        return $this->hasMany('App\Models\Product');
    }

    public function contactPersons()
    {
        return $this->morphMany(ContactPerson::class, 'contactable');
    }
}
