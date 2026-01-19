<?php

namespace App\Concerns;

use Filament\Support\Colors\Color;

trait UseColorsTrait
{
    public function useColors(): array
    {
        return [
            'primary' => Color::Yellow,
            'whatsapp' => '#25d366',
            'facebook' => '#1877f2',
            'instagram' => '#c32aa3',
            'x_twitter' => '#000000',
            'youtube' => '#ff0000',
            'linkedin' => '#0a66c2',
            'tiktok' => '#010101',
            'pinterest' => '#bd081c',
        ];
        /* Pour info, couleurs definies par defaut
            'danger' => Color::Red,
            'gray' => Color::Zinc,
            'info' => Color::Blue,
            'primary' => Color::Amber,
            'success' => Color::Green,
            'warning' => Color::Amber,
         */
    }
}
