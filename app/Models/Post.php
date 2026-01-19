<?php

namespace App\Models;

use App\Settings\GeneralSettings;
use Biostate\FilamentMenuBuilder\Traits\Menuable;
use Illuminate\Database\Eloquent\Attributes\Scope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;
use RalphJSmit\Laravel\SEO\Support\SEOData;
use Spatie\Image\Enums\Fit;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Post extends Model implements HasMedia
{
    use InteractsWithMedia, Menuable;

    protected $with = ['media', 'category', 'author'];

    protected $fillable = [
        'author_id',
        'category_id',
        'title',
        'slug',
        'excerpt',
        'content',
        'published_at',
    ];

    protected function casts(): array
    {
        return [
            'published_at' => 'date',
        ];
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

    protected function draft(Builder $query): void
    {
        $query->whereNull('published_at');
    }

    /*
    |--------------------------------------------------------------------------
    | RELATIONSHIPS
    |--------------------------------------------------------------------------
    */
    /**
     * @return BelongsTo<Post, User>
     */
    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class, 'author_id');
    }

    /**
     * @return BelongsTo<Post, Category>
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    /*
   |--------------------------------------------------------------------------
   | UTILITIES
   |--------------------------------------------------------------------------
   */
    public function registerMediaCollections(): void
    {
        $this
            ->addMediaCollection('featured_image')
            ->useFallbackUrl(asset('storage/'.app(GeneralSettings::class)->fallback_logo))
            ->useFallbackPath(public_path(app(GeneralSettings::class)->fallback_logo))
            ->singleFile()
            ->registerMediaConversions(function (Media $media) {
                $this
                    ->addMediaConversion('webp')
                    ->format('webp');

                $this
                    ->addMediaConversion('square')
                    ->fit(Fit::Crop, 550, 550)
                    ->format('webp');
            });
    }

    protected function generateExcerpt(): Attribute
    {
        return Attribute::make(
            get: fn (mixed $value, array $attributes) => Str::limit(filled($attributes['excerpt']) ? $attributes['excerpt'] : strip_tags($attributes['content']), 160)
        );
    }

    public function getDynamicSEOData(): SEOData
    {
        return new SEOData(
            title: Str::limit($this->title, 60),
            description: $this->generateExcerpt,
            author: $this->author ? $this->author->full_name : getClientName(),
            robots: 'index, follow'
        );
    }

    public function getMenuLinkAttribute(): string
    {
        return route('post.show', $this);
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
