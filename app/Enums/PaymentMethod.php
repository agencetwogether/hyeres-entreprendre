<?php

namespace App\Enums;

use Filament\Support\Contracts\HasLabel;

enum PaymentMethod: string implements HasLabel
{
    // case CREDIT_CARD = 'credit_card';
    case BANK_TRANSFER = 'bank_transfer';
    case CASH = 'cash';
    case PAYPAL = 'paypal';
    case OTHER = 'other';
    case NC = 'nc';

    public function getLabel(): ?string
    {
        return match ($this) {
            // self::CREDIT_CARD => __('app.general.enum_payment_method.credit_card'),
            self::BANK_TRANSFER => __('app.general.enum_payment_method.bank_transfer'),
            self::CASH => __('app.general.enum_payment_method.cash'),
            self::PAYPAL => __('app.general.enum_payment_method.paypal'),
            self::OTHER => __('app.general.enum_payment_method.other'),
            self::NC => __('app.general.enum_payment_method.nc'),
        };
    }
}
