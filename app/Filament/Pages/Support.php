<?php

namespace App\Filament\Pages;

use App\Events\SendSupport;
use BackedEnum;
use BezhanSalleh\FilamentShield\Traits\HasPageShield;
use Filament\Actions\Action;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Illuminate\Contracts\Support\Htmlable;
use Throwable;

class Support extends Page
{
    use HasPageShield;

    public ?array $data = [];

    protected static string|null|BackedEnum $navigationIcon = 'phosphor-lifebuoy';

    protected string $view = 'filament.pages.support.support';

    protected static ?string $slug = 'support';

    public function getTitle(): string|Htmlable
    {
        return __('app.pages.support.title');
    }

    public static function getNavigationLabel(): string
    {
        return __('app.pages.support.navigation_title');
    }

    public static function getNavigationGroup(): ?string
    {
        return __('app.general.navigation.groups.support');
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make(__('app.pages.support.form.section.title'))
                    ->description(__('app.pages.support.form.section.description'))
                    ->icon('phosphor-lifebuoy')
                    ->iconColor('success')
                    ->schema([
                        TextInput::make('subject')
                            ->label(__('app.pages.support.form.label.subject'))
                            ->placeholder(__('app.pages.support.form.placeholder.subject'))
                            ->required(),
                        Textarea::make('content')
                            ->label(__('app.pages.support.form.label.content'))
                            ->placeholder(__('app.pages.support.form.placeholder.content'))
                            ->rows(10)
                            ->cols(20)
                            ->required(),
                    ]),
            ])
            ->statePath('data');

    }

    public function sendAction(): Action
    {
        return Action::make('save')
            ->label(__('app.pages.support.action.label.send'))
            ->submit('send')
            ->keyBindings(['mod+s']);
    }

    public function send(): void
    {
        try {
            $data = $this->form->getState();

            SendSupport::dispatch($data);

            Notification::make()
                ->title(__('app.pages.support.notification.success'))
                ->success()
                ->send();

            $this->redirect(static::getUrl());
        } catch (Throwable $th) {
            throw $th;
            Notification::make()
                ->title(__('app.pages.support.notification.error'))
                ->danger()
                ->send();
        }
    }
}
