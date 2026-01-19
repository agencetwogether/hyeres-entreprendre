<?php

namespace App\Services;

use Filament\Forms\Components\RichEditor\TextColor;
use Illuminate\Support\Arr;

class RichEditorService
{
    public function getColors(bool $includeDefaults = false): array
    {
        $colors = [
            'primary' => TextColor::make('Principale', '#f0aa0b', darkColor: '#f7bc18'),
            'secondary' => TextColor::make('Secondaire', '#7a81b7', darkColor: '#949dc6'),
        ];

        if ($includeDefaults) {
            $colors = Arr::collapse([$colors, TextColor::getDefaults()]);
        }

        return $colors;
    }

    public function getToolbarButtonsEditorSimple(): array
    {
        return [
            ['bold', 'italic', 'underline', 'strike', 'link'],
            ['bulletList', 'orderedList'],
            ['undo', 'redo', 'clearFormatting'],
        ];
    }

    public function getToolbarButtonsEditorSimpleWithColor(): array
    {
        return [
            ['bold', 'italic', 'underline', 'strike', 'link', 'textColor'],
            ['bulletList', 'orderedList'],
            ['undo', 'redo', 'clearFormatting'],
        ];
    }

    public function getToolbarButtonsEditorSimpleWithHeading(): array
    {
        return [
            ['h2', 'h3'],
            ['bold', 'italic', 'underline', 'strike', 'link'],
            ['bulletList', 'orderedList'],
            ['undo', 'redo', 'clearFormatting'],
        ];
    }

    public function getToolbarButtonsEditorComplete(): array
    {
        return [
            ['h2', 'h3', 'alignStart', 'alignCenter', 'alignJustify', 'alignEnd'],
            ['bold', 'italic', 'underline', 'strike', 'link', 'textColor'],
            ['bulletList', 'orderedList'],
            ['attachFiles'],
            // ['table', 'attachFiles'],
            ['undo', 'redo', 'clearFormatting'],
        ];
    }

    public function getToolbarButtonsEditorWithColorAndImage(): array
    {
        return [
            ['bold', 'italic', 'underline', 'strike', 'link', 'textColor'],
            ['alignStart', 'alignCenter', 'alignJustify', 'alignEnd'],
            ['bulletList', 'orderedList'],
            ['attachFiles'],
            ['undo', 'redo', 'clearFormatting'],
        ];
    }
}
