<?php

namespace App\Models;

use App\Enums\DiscountRate;
use App\Enums\StatusContact;
use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    protected $fillable = [
        'name',
        'firstname',
        'email',
        'phone',
        'content',
        'interested',
        'company',
        'activity',
        'street',
        'street_ext',
        'postal_code',
        'city',
        'rgpd',
        'response_sent',
        'response_date',
        'response_subject',
        'response_content',
        'has_discount',
        'discount_rate',
        'subscription_received',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'rgpd' => 'boolean',
            'interested' => 'boolean',
            'response_date' => 'datetime',
            'response_sent' => 'boolean',
            'has_discount' => 'boolean',
            'subscription_received' => 'boolean',
            'status' => StatusContact::class,
            'discount_rate' => DiscountRate::class,
        ];
    }
}
