<?php

namespace App\Filament\Resources\Members\Pages;

use App\Filament\Resources\Members\MemberResource;
use App\Filament\Resources\Members\Widgets\MemberStats;
use Filament\Actions\CreateAction;
use Filament\Pages\Concerns\ExposesTableToWidgets;
use Filament\Resources\Pages\ListRecords;
use Livewire\Attributes\On;

class ListMembers extends ListRecords
{
    use ExposesTableToWidgets;

    protected static string $resource = MemberResource::class;

    protected $listeners = [
        'refreshTableMembers' => '$refresh',
    ];

    #[On('setFilter')]
    public function updateTableFilter(string $filter): void
    {
        $this->tableFilters[$filter]['isActive'] = true;
    }

    public function getTitle(): string
    {
        return __('app.members.page.title_list');
    }

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()
                ->label(__('app.members.table.action.create.label')),
        ];
    }

    protected function getHeaderWidgets(): array
    {
        return [
            MemberStats::class,
        ];
    }
}
