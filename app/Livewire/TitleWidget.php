<?php

namespace App\Livewire;

use Closure;
use Filament\Support\Concerns\EvaluatesClosures;
use Filament\Support\Concerns\HasColor;
use Filament\Widgets\Widget;

class TitleWidget extends Widget
{
    use EvaluatesClosures;
    use HasColor;

    protected static ?string $pollingInterval = null;

    protected string|array|Closure|null $bgColor = null;

    protected string $view = 'filament.widgets.title';

    protected int|string|array $columnSpan = 'full';

    public function getTitle(): string
    {
        return '';
    }

    public function bgColor(string|array|Closure|null $color): static
    {
        $this->bgColor = $color;

        return $this;
    }

    public function getBgColor(): string|array|null
    {
        return $this->evaluate($this->bgColor) ?? $this->evaluate($this->color);
    }
}
