<?php

namespace App\Filament\Resources\Events\Schemas\Components;

use App\Models\Event;
use App\Services\RichEditorService;
use Carbon\Carbon;
use Filament\Actions\Action;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Fieldset;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Utilities\Set;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class EventFields
{
    public static function getThumbnail(): SpatieMediaLibraryFileUpload
    {
        return SpatieMediaLibraryFileUpload::make('featured_image')
            ->label(__('app.events.form.label.featured_image'))
            ->collection('banner')
            ->disk('public')
            ->visibility('public')
            ->image()
            ->imageAspectRatio('16:9')
            ->automaticallyOpenImageEditorForAspectRatio()
            ->automaticallyCropImagesToAspectRatio()
            ->automaticallyResizeImagesMode('cover')
            ->automaticallyResizeImagesToWidth('1920')
            ->automaticallyResizeImagesToHeight('1080');
    }

    public static function getTitle(): TextInput
    {
        return TextInput::make('title')
            ->label(__('app.events.form.label.title'))
            ->live(onBlur: true)
            ->afterStateUpdated(function (Get $get, Set $set, ?string $old, ?string $state) {
                if (($get('slug') ?? '') !== Str::slug($old)) {
                    return;
                }

                $set('slug', Str::slug($state));
            })
            ->required();
    }

    public static function getSlug(): TextInput
    {
        return TextInput::make('slug')
            ->label(__('app.events.form.label.slug'))
            ->required()
            ->unique(Event::class, 'slug', fn (?Model $record) => $record)
            ->readOnly();
    }

    public static function getExcerpt(): Textarea
    {
        return Textarea::make('excerpt')
            ->label(__('app.events.form.label.excerpt'))
            ->rows(3)
            ->hint(function (?string $state): string {
                return (string) Str::of(strlen($state))
                    ->append(' / ')
                    ->append(160 .' ')
                    ->append(__('app.general.characters'));
            })
            ->maxLength(160)
            ->live();
    }

    public static function getContent(): RichEditor
    {
        return RichEditor::make('content')
            ->label(__('app.events.form.label.content'))
            ->toolbarButtons(fn (RichEditorService $editorService): array => $editorService->getToolbarButtonsEditorComplete())
            ->textColors(fn (RichEditorService $editorService): array => $editorService->getColors())
            ->fileAttachmentsDirectory('events')
            ->resizableImages()
            ->customHeight();
    }

    public static function getDateStart(): DateTimePicker
    {
        return DateTimePicker::make('date_start')
            ->label(__('app.events.form.label.date_start'))
            ->native(false)
            ->seconds(false)
            ->minutesStep(15)
            ->displayFormat(getDisplayDate().' H:i')
            ->prefixIcon('phosphor-calendar')
            ->minDate(fn (string $operation): ?Carbon => $operation === 'create' ? Carbon::today() : null)
            ->live()
            ->afterStateUpdated(function (Get $get, $state, Set $set) {
                $dateEnd = $get('date_end');
                $dateStart = Carbon::parse($state);
                if ($dateEnd && Carbon::parse($dateEnd)->isBefore($dateStart)) {
                    $set('date_end', $dateStart->addHour());
                }
            })
            ->default(getNearestTimeRoundedUp(Carbon::now()))
            ->required();
    }

    public static function getDateEnd(): DateTimePicker
    {
        return DateTimePicker::make('date_end')
            ->label(__('app.events.form.label.date_end'))
            ->native(false)
            ->seconds(false)
            ->minutesStep(15)
            ->displayFormat(getDisplayDate().' H:i')
            ->prefixIcon('phosphor-calendar')
            ->minDate(function (Get $get, string $operation): ?Carbon {
                if ($operation == 'create') {
                    $dateStart = $get('date_start');
                    if ($dateStart == null) {
                        return Carbon::today();
                    } else {
                        return Carbon::parse($dateStart);
                    }
                }

                return null;
            })
            ->suffixAction(
                Action::make('erase-field')
                    ->tooltip(__('app.events.form.helper.erase_date_end'))
                    ->icon('phosphor-trash')
                    ->color('danger')
                    ->action(function (Set $set) {
                        $set('date_end', null);
                    })
            );
    }

    public static function getPublishedAt(): DatePicker
    {
        return DatePicker::make('published_at')
            ->label(__('app.events.form.label.published_at'))
            ->native(false)
            ->displayFormat(getDisplayDate())
            ->closeOnDateSelection()
            ->prefixIcon('phosphor-calendar')
            ->minDate(fn (string $operation): ?Carbon => $operation == 'create' ? Carbon::today() : null);
    }

    public static function getLocation(): TextInput
    {
        return TextInput::make('location')
            ->label(__('app.events.form.label.location'));
    }

    public static function getPrice(): TextInput
    {
        return TextInput::make('price')
            ->label(__('app.events.form.label.price'))
            ->suffixIcon('phosphor-currency-eur');
    }

    public static function getExternalLink(): Fieldset
    {
        return Fieldset::make(__('app.events.form.label.fieldset.external_link.label'))
            ->schema([
                Toggle::make('external_link.link_is_visible')
                    ->label(__('app.events.form.label.fieldset.external_link.link_is_visible'))
                    ->onColor('success')
                    ->offColor('danger')
                    ->columnSpanFull(),
                TextInput::make('external_link.link_label')
                    ->label(__('app.events.form.label.fieldset.external_link.link_label'))
                    ->default('Inscription')
                    ->requiredIfAccepted('external_link.link_is_visible'),
                TextInput::make('external_link.link_url')
                    ->label(__('app.events.form.label.fieldset.external_link.link_url'))
                    ->helperText(__('app.events.form.helper.external_link'))
                    ->prefixIcon('phosphor-globe')
                    ->url()
                    ->requiredIfAccepted('external_link.link_is_visible'),
            ]);
    }
}
