<?php

namespace App\Models;

use App\Settings\GeneralSettings;
use Biostate\FilamentMenuBuilder\Traits\Menuable;
use Illuminate\Database\Eloquent\Attributes\Scope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use RalphJSmit\Laravel\SEO\Support\SEOData;
use Spatie\Image\Enums\Fit;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Event extends Model implements HasMedia
{
    use InteractsWithMedia, Menuable;

    protected $fillable = [
        'title',
        'slug',
        'excerpt',
        'content',
        'date_start',
        'date_end',
        'location',
        'price',
        'external_link',
        'published_at',
    ];

    protected function casts(): array
    {
        return [
            'date_start' => 'datetime',
            'date_end' => 'datetime',
            'published_at' => 'date',
            'external_link' => 'array',
        ];
    }

    /*
    |--------------------------------------------------------------------------
    | ACCESSORS
    |--------------------------------------------------------------------------
    */
    protected function generateExcerpt(): Attribute
    {
        return Attribute::make(
            get: fn (mixed $value, array $attributes) => Str::limit(filled($attributes['excerpt']) ? $attributes['excerpt'] : strip_tags($attributes['content']), 160)
        );
    }

    /*
    |--------------------------------------------------------------------------
    | SCOPES
    |--------------------------------------------------------------------------
    */
    #[Scope]
    protected function published(Builder $query): void
    {
        $query->whereNotNull('published_at');
    }

    #[Scope]
    protected function draft(Builder $query): void
    {
        $query->whereNull('published_at');
    }

    /*
    |--------------------------------------------------------------------------
    | UTILITIES
    |--------------------------------------------------------------------------
    */
    public function registerMediaCollections(): void
    {
        $this
            ->addMediaCollection('banner')
            ->useFallbackUrl(asset('storage/'.app(GeneralSettings::class)->fallback_logo))
            ->useFallbackPath(public_path(app(GeneralSettings::class)->fallback_logo))
            ->singleFile()
            ->registerMediaConversions(function (Media $media) {
                $this
                    ->addMediaConversion('webp')
                    ->format('webp');

                $this
                    ->addMediaConversion('square')
                    ->fit(Fit::Crop, 400, 400)
                    ->format('webp');
            });
    }

    public function getDynamicSEOData(): SEOData
    {
        return new SEOData(
            title: Str::limit($this->title, 60),
            description: $this->generateExcerpt,
            robots: 'index, follow'
        );
    }

    public function getMenuLinkAttribute(): string
    {
        return route('event.show', $this);
    }

    public function getMenuNameAttribute(): string
    {
        return $this->title;
    }

    public static function getFilamentSearchLabel(): string
    {
        return 'title';
    }
}
