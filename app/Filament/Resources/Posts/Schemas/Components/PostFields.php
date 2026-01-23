<?php

namespace App\Filament\Resources\Posts\Schemas\Components;

use App\Models\Post;
use App\Services\RichEditorService;
use Carbon\Carbon;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Utilities\Set;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class PostFields
{
    public static function getThumbnail(): SpatieMediaLibraryFileUpload
    {
        return SpatieMediaLibraryFileUpload::make('featured_image')
            ->label(__('app.posts.form.label.featured_image'))
            ->collection('featured_image')
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
            ->label(__('app.posts.form.label.title'))
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
            ->label(__('app.posts.form.label.slug'))
            ->required()
            ->unique(Post::class, 'slug', fn (?Model $record) => $record)
            ->readOnly();
    }

    public static function getExcerpt(): Textarea
    {
        return Textarea::make('excerpt')
            ->label(__('app.posts.form.label.excerpt'))
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
            ->label(__('app.posts.form.label.content'))
            ->toolbarButtons(fn (RichEditorService $editorService): array => $editorService->getToolbarButtonsEditorComplete())
            ->textColors(fn (RichEditorService $editorService): array => $editorService->getColors())
            ->fileAttachmentsDirectory('posts')
            ->resizableImages();
    }

    public static function getPublishedAt(): DatePicker
    {
        return DatePicker::make('published_at')
            ->label(__('app.posts.form.label.published_at'))
            ->native(false)
            ->displayFormat(getDisplayDate())
            ->closeOnDateSelection()
            ->prefixIcon('phosphor-calendar')
            ->minDate(fn (string $operation): ?Carbon => $operation == 'create' ? Carbon::today() : null);
    }

    public static function getAuthor(): Select
    {
        return Select::make('author_id')
            ->label(__('app.posts.form.label.author'))
            ->native(false)
            ->relationship(name: 'author', titleAttribute: 'name')
            ->getOptionLabelFromRecordUsing(fn (Model $record): string => $record->getFilamentName())
            ->searchable()
            ->preload()
            ->default(auth()->user()->id);
    }

    public static function getCategory(): Select
    {
        return Select::make('category_id')
            ->label(__('app.posts.form.label.category'))
            ->native(false)
            ->relationship(name: 'category', titleAttribute: 'name')
            ->searchable()
            ->preload();
    }
}
