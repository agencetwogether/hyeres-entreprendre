<?php

namespace App\Filament\Resources\Posts\Schemas;

use App\Filament\Resources\Posts\PostResource;
use App\Filament\Resources\Posts\Schemas\Components\PostFields;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class PostForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make(__('app.posts.form.section.post.title'))
                    ->icon(PostResource::getNavigationIcon())
                    ->iconColor('primary')
                    ->description(__('app.posts.form.section.post.description'))
                    ->schema([
                        PostFields::getThumbnail()
                            ->columnSpan(1),
                        PostFields::getPublishedAt()
                            ->columnSpan(1),
                        PostFields::getTitle()
                            ->columnSpan(1),
                        PostFields::getSlug()
                            ->columnSpan(1),
                        PostFields::getExcerpt()
                            ->columnSpanFull(),
                        PostFields::getContent()
                            ->customHeight()
                            ->columnSpanFull(),
                        PostFields::getCategory()
                            ->columnSpan(1),
                        PostFields::getAuthor()
                            ->columnSpan(1),
                    ])
                    ->columns(),
            ]);
    }
}
