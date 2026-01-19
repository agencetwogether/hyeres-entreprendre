<?php

namespace App\Filament\Pages;

use App\Events\SendCommunication;
use App\Models\Member;
use App\Models\User;
use App\Services\RichEditorService;
use BackedEnum;
use BezhanSalleh\FilamentShield\Traits\HasPageShield;
use Filament\Actions\Action;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Pages\Concerns\InteractsWithFormActions;
use Filament\Pages\Page;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;
use Illuminate\Contracts\Support\Htmlable;
use Throwable;

class Communication extends Page
{
    use HasPageShield, InteractsWithFormActions;

    protected static string|null|BackedEnum $navigationIcon = 'phosphor-megaphone';

    public function getTitle(): string|Htmlable
    {
        return __('app.pages.communication.title');
    }

    public static function getNavigationLabel(): string
    {
        return __('app.pages.communication.navigation_title');
    }

    public static function getNavigationGroup(): ?string
    {
        return __('app.general.navigation.groups.support');
    }

    protected string $view = 'filament.pages.communication.communication';

    public ?array $data = [];

    public function mount(): void
    {
        $this->form->fill();
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make(__('app.pages.communication.form.section.title'))
                    ->description(__('app.pages.communication.form.section.description'))
                    ->icon('phosphor-megaphone')
                    ->iconColor('primary')
                    ->schema([
                        Select::make('model')
                            ->label(__('app.pages.communication.form.label.model'))
                            ->options([
                                'member' => 'Membres',
                                'user' => 'Utilisateurs',
                            ])
                            ->native(false)
                            ->selectablePlaceholder(false)
                            ->live()
                            ->afterStateUpdated(function (Set $set) {
                                $set('recipients', []);
                            })
                            ->required()
                            ->columnSpan(1),

                        Select::make('recipients')
                            ->label(__('app.pages.communication.form.label.recipients'))
                            ->options(fn (Get $get): array => match ($get('model')) {
                                'member' => Member::query()->get()->mapWithKeys(function (Member $member) {
                                    return [$member['id'] => $member->getFullName().' - '.$member->company_name];
                                })->toArray(),
                                'user' => User::query()->get()->mapWithKeys(function (User $user) {
                                    $roles = $user->getRoleNames()->map(function ($item) {
                                        return $item->getLabel();
                                    })->toArray();

                                    return [$user['id'] => $user->getFilamentName().' - '.implode(', ', $roles)];
                                })->toArray(),
                                default => [],
                            })
                            ->multiple()
                            ->hintAction(
                                Action::make('select_all')
                                    ->label(__('app.pages.communication.form.label.select_all'))
                                    ->action(function (Set $set, Select $component) {
                                        $set($component->getStatePath(false), array_keys($component->getOptions()));
                                    })
                            )
                            ->required()
                            ->columnSpan(1),
                        TextInput::make('subject')
                            ->label(__('app.pages.communication.form.label.subject'))
                            ->required()
                            ->columnSpanFull(),
                        RichEditor::make('content')
                            ->label(__('app.pages.communication.form.label.content'))
                            ->customHeight()
                            ->toolbarButtons(fn (RichEditorService $editorService): array => $editorService->getToolbarButtonsEditorSimple())
                            ->required()
                            ->columnSpanFull(),
                    ])
                    ->columns()
                    ->statePath('data'),
            ]);

    }

    public function getSendAction(): Action
    {
        return Action::make('save')
            ->label(__('app.pages.communication.action.label.send'))
            ->submit('send')
            ->keyBindings(['mod+s']);
    }

    public function send(): void
    {
        try {
            $data = $this->form->getState();

            SendCommunication::dispatch($data);

            Notification::make()
                ->title(__('app.pages.communication.notification.success'))
                ->success()
                ->send();

            $this->redirect(static::getUrl());
        } catch (Throwable $th) {
            throw $th;
            Notification::make()
                ->title(__('app.pages.communication.notification.error'))
                ->danger()
                ->send();
        }
    }
}
