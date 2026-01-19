<?php

namespace App\Enums;

use Blade;
use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasIcon;
use Filament\Support\Contracts\HasLabel;

use function Filament\Support\get_color_css_variables;

enum SocialNetwork: string implements HasColor, HasIcon, HasLabel
{
    case WHATSAPP = 'whatsapp';
    case FACEBOOK = 'facebook';
    case INSTAGRAM = 'instagram';
    case TWITTER = 'x_twitter';
    case YOUTUBE = 'youtube';
    case LINKEDIN = 'linkedin';
    case TIKTOK = 'tiktok';
    case PINTEREST = 'pinterest';

    public function getColor(): string|array|null
    {
        return match ($this) {
            self::WHATSAPP => 'whatsapp',
            self::FACEBOOK => 'facebook',
            self::INSTAGRAM => 'instagram',
            self::TWITTER => 'x_twitter',
            self::YOUTUBE => 'youtube',
            self::LINKEDIN => 'linkedin',
            self::TIKTOK => 'tiktok',
            self::PINTEREST => 'pinterest'
        };
    }

    public function getHexColor(): string
    {
        // See also UseColorsTrait.php
        return match ($this) {
            self::WHATSAPP => '#25d366',
            self::FACEBOOK => '#1877f2',
            self::INSTAGRAM => '#c32aa3',
            self::TWITTER => '#000000',
            self::YOUTUBE => '#ff0000',
            self::LINKEDIN => '#0a66c2',
            self::TIKTOK => '#010101',
            self::PINTEREST => '#bd081c',
        };
    }

    public function getIcon(): ?string
    {
        return match ($this) {
            self::WHATSAPP => 'phosphor-whatsapp-logo',
            self::FACEBOOK => 'phosphor-facebook-logo',
            self::INSTAGRAM => 'phosphor-instagram-logo',
            self::TWITTER => 'phosphor-x-logo',
            self::YOUTUBE => 'phosphor-youtube-logo',
            self::LINKEDIN => 'phosphor-linkedin-logo',
            self::TIKTOK => 'phosphor-tiktok-logo',
            self::PINTEREST => 'phosphor-pinterest-logo',
        };
    }

    public function getLabel(): ?string
    {
        return match ($this) {
            self::WHATSAPP => 'WhatsApp',
            self::FACEBOOK => 'Facebook',
            self::INSTAGRAM => 'Instagram',
            self::TWITTER => 'X',
            self::YOUTUBE => 'YouTube',
            self::LINKEDIN => 'LinkedIn',
            self::TIKTOK => 'TikTok',
            self::PINTEREST => 'Pinterest',
        };
    }

    public static function options(): array
    {
        return collect(self::cases())->mapWithKeys(function ($item) {

            return [$item->value => Blade::render("<span class='flex items-center gap-x-4'><x-filament::icon icon='".$item->getIcon()."' class='text-custom-500 h-6 w-6' style='".get_color_css_variables($item->getColor(), shades: [500])."'/><span>".$item->getLabel().'</span></span>')];
        })->toArray();
    }
}
