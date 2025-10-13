<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $fillable = [
        "customer_group_id",
        "user_id",
        "name",
        "company_name",
        "email",
        "phone_number",
        "tax_no",
        "address",
        "city",
        "state",
        "postal_code",
        "country",
        "points",
        "deposit",
        "expense",
        "is_active",
        "bin_number"
    ];

    public function customerGroup()
    {
        return $this->belongsTo('App\Models\CustomerGroup');
    }

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    public function discountPlans()
    {
        return $this->belongsToMany('App\Models\DiscountPlan', 'discount_plan_customers');
    }

    public function contactPersons()
    {
        return $this->morphMany(ContactPerson::class, 'contactable');
    }
}
