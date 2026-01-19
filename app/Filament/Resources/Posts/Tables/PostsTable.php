<?php

namespace App\Filament\Resources\Posts\Tables;

use App\Filament\Resources\Posts\PostResource;
use App\Filament\Resources\Posts\Tables\Components\PostColumns;
use Filament\Actions\ActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;

class PostsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                PostColumns::getThumbnail(),
                PostColumns::getTitle(),
                PostColumns::getSlug(),
                PostColumns::getExcerpt(),
                PostColumns::getPublishedAt(),
                PostColumns::getAuthor(),
                PostColumns::getCategory(),
            ])
            ->defaultSort('published_at', 'desc')
            ->recordActions([
                ActionGroup::make([
                    EditAction::make()
                        ->label(__('app.posts.table.action.edit.label')),
                    DeleteAction::make()
                        ->label(__('app.posts.table.action.delete.label'))
                        ->modalHeading(fn (Model $record): string => __('app.posts.table.action.delete.modal.heading', ['title' => $record->title]))
                        ->modalDescription(__('app.posts.table.action.delete.modal.description'))
                        ->successNotificationTitle(fn (Model $record): string => __('app.posts.table.action.delete.modal.notification_success', ['title' => $record->title])),
                ]),
            ])
            ->emptyStateIcon(PostResource::getNavigationIcon())
            ->emptyStateHeading(__('app.posts.table.empty_state.heading'))
            ->emptyStateDescription(__('app.posts.table.empty_state.description'));
    }
}
