<?php

namespace App\Enums;

use Filament\Support\Contracts\HasLabel;

enum DiscountRate: int implements HasLabel
{
    case FIVE = 5;
    case TEN = 10;
    case FIFTEEN = 15;
    case TWENTY = 20;
    case TWENTYFIVE = 25;
    case THIRTY = 30;
    case THIRTYFIVE = 35;
    case FORTY = 40;
    case FORTYFIVE = 45;
    case FIFTY = 50;
    case FIFTYFIVE = 55;
    case SIXTY = 60;
    case SIXTYFIVE = 65;
    case SEVENTY = 70;
    case SEVENTYFIVE = 75;
    case EIGHTY = 80;
    case EIGHTYFIVE = 85;
    case NINETY = 90;
    case NINETYFIVE = 95;

    public function getLabel(): ?string
    {
        return match ($this) {
            self::FIVE => '5%',
            self::TEN => '10%',
            self::FIFTEEN => '15%',
            self::TWENTY => '20%',
            self::TWENTYFIVE => '25%',
            self::THIRTY => '30%',
            self::THIRTYFIVE => '35%',
            self::FORTY => '40%',
            self::FORTYFIVE => '45%',
            self::FIFTY => '50%',
            self::FIFTYFIVE => '55%',
            self::SIXTY => '60%',
            self::SIXTYFIVE => '65%',
            self::SEVENTY => '70%',
            self::SEVENTYFIVE => '75%',
            self::EIGHTY => '80%',
            self::EIGHTYFIVE => '85%',
            self::NINETY => '90%',
            self::NINETYFIVE => '95%'
        };
    }
}
