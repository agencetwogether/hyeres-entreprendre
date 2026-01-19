<?php

namespace App\Filament\Resources\Users\Pages;

use App\Filament\Forms\Components\PermissionGroup;
use App\Filament\Resources\Users\UserResource;
use Awcodes\Shout\Components\Shout;
use Filament\Resources\Pages\EditRecord;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Illuminate\Database\Eloquent\Model;

class EditUserPermission extends EditRecord
{
    protected static string $resource = UserResource::class;

    protected function authorizeAccess(): void
    {
        abort_unless(auth()->user()->can('UpdateCustomPermission:User'), 403);
    }

    public function getTitle(): string
    {
        return __('app.pages.edit-permission.title', ['name' => $this->record->getFilamentName()]);
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make(__('app.pages.edit-permission.form.section.title'))
                    ->description(__('app.pages.edit-permission.form.section.description'))
                    ->icon('phosphor-shield-plus')
                    ->iconColor('success')
                    ->schema([
                        Shout::make('reminder_role')
                            ->content(view('filament.resources.users.permissions.assign', ['user' => $this->getRecord()]))
                            ->columnSpanFull(),

                        PermissionGroup::make('permissions')
                            ->hiddenLabel()
                            ->searchable()
                            ->validationAttribute(__('Permissions'))
                            ->resolveStateUsing(fn (Model $record): array => $record->getAllPermissions()->pluck('id')->all())
                            ->columns([
                                'md' => 2,
                                'xl' => 3,
                            ]),
                    ])
                    ->columnSpanFull(),
            ]);
    }
}
