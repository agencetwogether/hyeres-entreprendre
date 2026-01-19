<?php

namespace App\Filament\Pages;

use App\Services\RichEditorService;
use App\Settings\SectionsSettings;
use BackedEnum;
use BezhanSalleh\FilamentShield\Traits\HasPageShield;
use Filament\Actions\Action;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Notifications\Notification;
use Filament\Pages\SettingsPage;
use Filament\Schemas\Components\Fieldset;
use Filament\Schemas\Schema;
use Filament\Support\Exceptions\Halt;
use Illuminate\Contracts\Support\Htmlable;
use Throwable;

class ManageSectionsSettings extends SettingsPage
{
    use HasPageShield;

    protected static string $settings = SectionsSettings::class;

    protected static string|null|BackedEnum $navigationIcon = 'phosphor-stack';

    protected string $view = 'filament.pages.manage-sections.main';

    public ?array $introductionData = [];

    public ?array $presentationData = [];

    public ?array $joinData = [];

    public static function getNavigationGroup(): ?string
    {
        return __('app.general.navigation.groups.settings');
    }

    public function getTitle(): string|Htmlable
    {
        return __('app.pages.manage-sections.title');
    }

    public static function getNavigationLabel(): string
    {
        return __('app.pages.manage-sections.navigation_title');
    }

    public function mount(): void
    {
        $this->fillForms();
    }

    protected function fillForms(): void
    {
        $settings = app(static::getSettings());

        $data = $settings->toArray();

        $this->editIntroductionForm->fill($data);
        $this->editPresentationForm->fill($data);
        $this->editJoinForm->fill($data);
    }

    protected function getForms(): array
    {
        return [
            'editIntroductionForm',
            'editPresentationForm',
            'editJoinForm',
        ];
    }

    public function editIntroductionForm(Schema $schema): Schema
    {
        return $schema
            ->components([
                Toggle::make('introduction.is_visible')
                    ->label(__('app.pages.manage-sections.form.label.is_visible'))
                    ->onColor('success')
                    ->offColor('danger')
                    ->columnSpan(1),
                FileUpload::make('introduction.image')
                    ->label(__('app.pages.manage-sections.form.label.image_background'))
                    ->directory('intro')
                    ->image()
                    ->optimize('webp')
                    ->imageAspectRatio('16:9')
                    ->automaticallyOpenImageEditorForAspectRatio()
                    ->automaticallyCropImagesToAspectRatio()
                    ->automaticallyResizeImagesMode('cover')
                    ->automaticallyResizeImagesToWidth('1920')
                    ->automaticallyResizeImagesToHeight('1080')
                    ->columnSpan(3),
                RichEditor::make('introduction.title')
                    ->label(__('app.pages.manage-sections.form.label.title'))
                    ->toolbarButtons([
                        ['bold', 'italic', 'textColor'],
                    ])
                    ->textColors(fn (RichEditorService $editorService) => $editorService->getColors())
                    ->customTextColors()
                    ->required()
                    ->columnSpan(2),
                TextInput::make('introduction.subtitle')
                    ->label(__('app.pages.manage-sections.form.label.subtitle'))
                    ->columnSpan(2),
                RichEditor::make('introduction.content')
                    ->label(__('app.pages.manage-sections.form.label.content'))
                    ->toolbarButtons(fn (RichEditorService $editorService) => $editorService->getToolbarButtonsEditorSimple())
                    ->customHeight()
                    ->columnSpanFull()
                    ->required(),
                Fieldset::make(__('app.pages.manage-sections.form.fieldset.link.title'))
                    ->schema([
                        Toggle::make('introduction.link.is_visible')
                            ->label(__('app.pages.manage-sections.form.fieldset.link.is_visible'))
                            ->onColor('success')
                            ->offColor('danger')
                            ->columnSpanFull(),
                        TextInput::make('introduction.link.label')
                            ->label(__('app.pages.manage-sections.form.fieldset.link.label'))
                            ->requiredIfAccepted('introduction.link.is_visible'),
                        TextInput::make('introduction.link.url')
                            ->label(__('app.pages.manage-sections.form.fieldset.link.url'))
                            ->url()
                            ->requiredIfAccepted('introduction.link.is_visible'),
                    ]),
            ])
            ->columns(4)
            ->statePath('introductionData');
    }

    public function editPresentationForm(Schema $schema): Schema
    {
        return $schema
            ->components([
                Toggle::make('presentation.is_visible')
                    ->label(__('app.pages.manage-sections.form.label.is_visible'))
                    ->onColor('success')
                    ->offColor('danger')
                    ->columnSpanFull(),
                TextInput::make('presentation.title')
                    ->label(__('app.pages.manage-sections.form.label.title'))
                    ->columnSpan(1)
                    ->required(),
                TextInput::make('presentation.subtitle')
                    ->label(__('app.pages.manage-sections.form.label.subtitle'))
                    ->columnSpan(1),
                RichEditor::make('presentation.content')
                    ->label(__('app.pages.manage-sections.form.label.content'))
                    ->toolbarButtons(fn (RichEditorService $editorService) => $editorService->getToolbarButtonsEditorSimple())
                    ->customHeight()
                    ->columnSpanFull()
                    ->required(),
                FileUpload::make('presentation.slider')
                    ->label(__('app.pages.manage-sections.form.label.slider'))
                    ->directory('slider-presentation')
                    ->image()
                    ->optimize('webp')
                    ->imageAspectRatio('1:1')
                    ->automaticallyCropImagesToAspectRatio()
                    ->automaticallyResizeImagesMode('cover')
                    ->automaticallyResizeImagesToWidth('550')
                    ->automaticallyResizeImagesToHeight('550')
                    ->multiple()
                    ->minFiles(1)
                    ->reorderable()
                    ->appendFiles()
                    ->panelLayout('grid')
                    ->columnSpanFull(),
            ])
            ->columns()
            ->statePath('presentationData');
    }

    public function editJoinForm(Schema $schema): Schema
    {
        return $schema
            ->components([
                Toggle::make('join.is_visible')
                    ->label(__('app.pages.manage-sections.form.label.is_visible'))
                    ->onColor('success')
                    ->offColor('danger')
                    ->columnSpanFull(),
                TextInput::make('join.title')
                    ->label(__('app.pages.manage-sections.form.label.title'))
                    ->columnSpanFull()
                    ->required(),
                RichEditor::make('join.content')
                    ->label(__('app.pages.manage-sections.form.label.content'))
                    ->toolbarButtons(fn (RichEditorService $editorService) => $editorService->getToolbarButtonsEditorSimple())
                    ->customHeight()
                    ->columnSpanFull()
                    ->required(),
                Repeater::make('join.links')
                    ->label(__('app.pages.manage-sections.form.label.repeater.links.title'))
                    ->itemLabel(fn (array $state): ?string => $state['label'] ?? null)
                    ->collapsible()
                    ->addActionLabel(__('app.pages.manage-sections.form.label.repeater.links.add_item'))
                    ->minItems(1)
                    ->columnSpanFull()
                    ->schema([
                        TextInput::make('label')
                            ->label(__('app.pages.manage-sections.form.label.repeater.links.label')),
                        TextInput::make('url')
                            ->label(__('app.pages.manage-sections.form.label.repeater.links.url'))
                            ->url(),
                        Select::make('style')
                            ->label(__('app.pages.manage-sections.form.label.repeater.links.style_label'))
                            ->default('primary')
                            ->options([
                                'primary' => __('app.pages.manage-sections.form.label.repeater.links.style.primary'),
                                'secondary' => __('app.pages.manage-sections.form.label.repeater.links.style.secondary'),
                            ]),
                    ]),
            ])
            ->columns()
            ->statePath('joinData');
    }

    public function updateIntroduction(): void
    {
        try {
            $this->beginDatabaseTransaction();

            $data = $this->editIntroductionForm->getState();

            $settings = app(static::getSettings());

            $settings->fill($data);
            $settings->save();

            $this->commitDatabaseTransaction();

        } catch (Halt $exception) {
            $exception->shouldRollbackDatabaseTransaction() ?
                $this->rollBackDatabaseTransaction() :
                $this->commitDatabaseTransaction();

            return;
        } catch (Throwable $exception) {
            $this->rollBackDatabaseTransaction();

            throw $exception;
        }

        $this->sendSuccessNotification(__('app.pages.manage-sections.notification.introduction'));
    }

    public function updatePresentation(): void
    {
        try {
            $this->beginDatabaseTransaction();

            $data = $this->editPresentationForm->getState();

            $settings = app(static::getSettings());

            $settings->fill($data);
            $settings->save();

            $this->commitDatabaseTransaction();

        } catch (Halt $exception) {
            $exception->shouldRollbackDatabaseTransaction() ?
                $this->rollBackDatabaseTransaction() :
                $this->commitDatabaseTransaction();

            return;
        } catch (Throwable $exception) {
            $this->rollBackDatabaseTransaction();

            throw $exception;
        }

        $this->sendSuccessNotification(__('app.pages.manage-sections.notification.presentation'));
    }

    public function updateJoin(): void
    {
        try {
            $this->beginDatabaseTransaction();

            $data = $this->editJoinForm->getState();

            $settings = app(static::getSettings());

            $settings->fill($data);
            $settings->save();

            $this->commitDatabaseTransaction();

        } catch (Halt $exception) {
            $exception->shouldRollbackDatabaseTransaction() ?
                $this->rollBackDatabaseTransaction() :
                $this->commitDatabaseTransaction();

            return;
        } catch (Throwable $exception) {
            $this->rollBackDatabaseTransaction();

            throw $exception;
        }

        $this->sendSuccessNotification(__('app.pages.manage-sections.notification.join'));
    }

    protected function getIntroductionFormTabTitle(): string
    {
        return __('app.pages.manage-sections.form.tabs.introduction');
    }

    protected function getPresentationFormTabTitle(): string
    {
        return __('app.pages.manage-sections.form.tabs.presentation');
    }

    protected function getJoinFormTabTitle(): string
    {
        return __('app.pages.manage-sections.form.tabs.join');
    }

    protected function getIntroductionFormTabSlug(): string
    {
        return str($this->getIntroductionFormTabTitle())->slug();
    }

    protected function getPresentationFormTabSlug(): string
    {
        return str($this->getPresentationFormTabTitle())->slug();
    }

    protected function getJoinFormTabSlug(): string
    {
        return str($this->getJoinFormTabTitle())->slug();
    }

    protected function getIntroductionFormTabIcon(): string
    {
        return 'phosphor-identification-card';
    }

    protected function getPresentationFormTabIcon(): string
    {
        return 'phosphor-presentation';
    }

    protected function getJoinFormTabIcon(): string
    {
        return 'phosphor-handshake';
    }

    protected function getUpdateIntroductionFormAction(): Action
    {
        return Action::make('updateIntroductionAction')
            ->label(__('app.pages.manage-sections.form.action.save'))
            ->submit('editIntroductionForm')
            ->keyBindings(['mod+s']);
    }

    protected function getUpdatePresentationFormAction(): Action
    {
        return Action::make('updatePresentationAction')
            ->label(__('app.pages.manage-sections.form.action.save'))
            ->submit('editPresentationForm')
            ->keyBindings(['mod+s']);
    }

    protected function getUpdateJoinFormAction(): Action
    {
        return Action::make('updateJoinAction')
            ->label(__('app.pages.manage-sections.form.action.save'))
            ->submit('editJoinForm')
            ->keyBindings(['mod+s']);
    }

    private function sendSuccessNotification(?string $title = null): void
    {
        Notification::make()
            ->success()
            ->title($title)
            ->send();
    }
}
