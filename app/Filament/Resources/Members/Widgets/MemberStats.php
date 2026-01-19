<?php

namespace App\Filament\Resources\Members\Widgets;

use App\Filament\Resources\Members\Pages\ListMembers;
use App\Models\Member;
use Filament\Widgets\Concerns\InteractsWithPageTable;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Database\Eloquent\Builder;

class MemberStats extends BaseWidget
{
    use InteractsWithPageTable;

    protected ?string $pollingInterval = null;

    protected function getTablePage(): string
    {
        return ListMembers::class;
    }

    protected function getStats(): array
    {
        return [
            Stat::make(__('app.members.table.widget.total_count'), Member::query()->count()),
            Stat::make(__('app.members.table.widget.draft'), Member::query()->where('is_draft', true)->count())
                ->extraAttributes([
                    'class' => 'transition hover:bg-danger-50 hover:dark:bg-danger-950 cursor-pointer',
                    'wire:click' => "\$dispatch('setFilter', { filter: 'is_draft' })",
                ]),
            Stat::make(__('app.members.table.widget.has_no_payment'), Member::query()->whereDoesntHave('onePlanSubscriptions', function (Builder $query) {
                $query->where('payment_received_at', '!=', null);
            })
                ->where('is_draft', false)->count())
                ->extraAttributes([
                    'class' => 'transition hover:bg-warning-50 hover:dark:bg-warning-950 cursor-pointer',
                    'wire:click' => "\$dispatch('setFilter', { filter: 'has_no_payment' })",
                ]),
        ];
    }
}
