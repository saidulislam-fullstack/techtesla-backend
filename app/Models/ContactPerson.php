<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContactPerson extends Model
{
    use HasFactory;

    protected $table = 'contact_persons';

    protected $fillable = [
        'contactable_type',
        'contactable_id',
        'name',
        'email',
        'phone',
        'designation',
        'visiting_card_front',
        'visiting_card_back',
    ];

    public function contactable()
    {
        return $this->morphTo();
    }
}
