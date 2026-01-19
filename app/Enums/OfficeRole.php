<?php

namespace App\Enums;

use Filament\Support\Contracts\HasLabel;

enum OfficeRole: string implements HasLabel
{
    case PRESIDENT = 'president';
    case VICEPRESIDENT = 'vice_president';
    case SECRETARY = 'secretary';
    case ASSISTANTSECRETARY = 'assistant_secretary';
    case TREASURER = 'treasurer';
    case ASSISTANTTREASURER = 'assistant_treasurer';

    public function getLabel(): ?string
    {
        return match ($this) {
            self::PRESIDENT => __('app.general.enum_office_role.president'),
            self::VICEPRESIDENT => __('app.general.enum_office_role.vice_president'),
            self::SECRETARY => __('app.general.enum_office_role.secretary'),
            self::ASSISTANTSECRETARY => __('app.general.enum_office_role.assistant_secretary'),
            self::TREASURER => __('app.general.enum_office_role.treasurer'),
            self::ASSISTANTTREASURER => __('app.general.enum_office_role.assistant_treasurer'),
        };
    }
}
