<?php

namespace App\Models;

use App\Enums\DiscountRate;
use App\Enums\PaymentMethod;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Invoice extends Model
{
    use HasUlids;

    protected $with = ['subscription.plan'];

    protected $fillable = [
        'amount',
        'discount_rate',
        'payment_mode',
        'payment_received_at',
        'starts_at',
        'ends_at',
        'subscription_id',
    ];

    protected function casts(): array
    {
        return [
            'amount' => 'float',
            'discount_rate' => DiscountRate::class,
            'payment_mode' => PaymentMethod::class,
            'payment_received_at' => 'datetime',
            'starts_at' => 'datetime',
            'ends_at' => 'datetime',
        ];
    }

    /**
     * Get the route key for the model.
     */
    public function getRouteKeyName(): string
    {
        return 'ulid';
    }

    /**
     * Get the columns that should receive a unique identifier.
     *
     * @return array<int, string>
     */
    public function uniqueIds(): array
    {
        return ['ulid'];
    }

    /*
    |--------------------------------------------------------------------------
    | RELATIONSHIPS
    |--------------------------------------------------------------------------
    */
    /**
     * @return BelongsTo<Invoice, Subscription>
     */
    public function subscription(): BelongsTo
    {
        return $this->belongsTo(Subscription::class, 'subscription_id');
    }
}
