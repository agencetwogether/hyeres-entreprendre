<?php

namespace App\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasLabel;

enum StatusContact: string implements HasColor, HasLabel
{
    case CREATED = 'created';
    case WAITING = 'waiting';
    // case RECEIVEDPAYMENT = 'received_payment';
    case COMPLETED = 'completed';

    public function getLabel(): ?string
    {
        return match ($this) {
            self::CREATED => __('app.general.enum_status_contact.created'),
            self::WAITING => __('app.general.enum_status_contact.waiting'),
            // self::RECEIVEDPAYMENT => __('app.general.enum_status_contact.received_payment'),
            self::COMPLETED => __('app.general.enum_status_contact.completed'),
        };
    }

    public function getColor(): string|array|null
    {
        return match ($this) {
            self::CREATED => 'danger',
            self::WAITING => 'warning',
            // self::RECEIVEDPAYMENT => 'info',
            self::COMPLETED => 'success',
        };
    }
}
