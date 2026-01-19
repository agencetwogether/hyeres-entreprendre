<?php

namespace App\Models;

use App\Enums\MemberType;
use App\Enums\OfficeRole;
use App\Settings\GeneralSettings;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Support\Str;
use Laravelcm\Subscriptions\Traits\HasPlanSubscriptions;
use RalphJSmit\Laravel\SEO\Support\SEOData;
use Spatie\Image\Enums\Fit;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Member extends Model implements HasMedia
{
    use HasPlanSubscriptions, HasUlids, InteractsWithMedia;

    protected $fillable = [
        'ulid',
        'user_id',
        'member_type',
        'office_role',
        'firstname',
        'name',
        'job',
        'phone',
        'email',
        'avatar',
        'company_name',
        'company_logo',
        'company_activity',
        'company_description',
        'company_street',
        'company_ext_street',
        'company_postal_code',
        'company_city',
        'company_website',
        'company_socials',
        'is_draft',
        'is_published',
        'account_created',
    ];

    protected function casts(): array
    {
        return [
            'member_type' => MemberType::class,
            'office_role' => OfficeRole::class,
            'company_socials' => 'array',
            'is_draft' => 'boolean',
            'is_published' => 'boolean',
            'account_created' => 'boolean',
        ];
    }

    protected $with = ['onePlanSubscriptions', 'media', 'user'];

    protected static function booted(): void
    {
        static::deleted(function (Member $member) {
            $member->planSubscriptions()->forceDelete();
        });
    }

    /**
     * Get the route key for the model.
     */
    public function getRouteKeyName(): string
    {
        return 'ulid';
    }

    /**
     * Get the columns that should receive a unique identifier.
     *
     * @return array<int, string>
     */
    public function uniqueIds(): array
    {
        return ['ulid'];
    }

    /*
    |--------------------------------------------------------------------------
    | RELATIONSHIPS
    |--------------------------------------------------------------------------
    */
    public function onePlanSubscriptions(): MorphOne
    {
        return $this->morphOne(related: config('laravel-subscriptions.models.subscription'),
            name: 'subscriber',
            type: 'subscriber_type',
            id: 'subscriber_id');
    }

    /**
     * @return BelongsTo<Member, User>
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /*
    |--------------------------------------------------------------------------
    | UTILITIES
    |--------------------------------------------------------------------------
    */
    public function getFullName(): string
    {
        if (filled($this->firstname)) {

            return $this->firstname.' '.$this->name;

        }

        return $this->name;
    }

    public function registerMediaCollections(): void
    {
        $this
            ->addMediaCollection('avatar')
            ->useFallbackUrl(asset('storage/'.app(GeneralSettings::class)->fallback_avatar))
            ->useFallbackPath(public_path(app(GeneralSettings::class)->fallback_avatar))
            ->singleFile()
            ->registerMediaConversions(function (Media $media) {
                $this
                    ->addMediaConversion('webp')
                    ->format('webp');
            });

        $this
            ->addMediaCollection('company_logo')
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
            title: Str::limit($this->company_name.' - '.$this->company_activity, 60),
            description: Str::limit(strip_tags($this->company_description), 160),
            robots: 'index, follow',
        );
    }

    /*
    |--------------------------------------------------------------------------
    | ACCESSORS
    |--------------------------------------------------------------------------
    */
    protected function firstname(): Attribute
    {
        return Attribute::make(
            get: fn (?string $value) => filled($value) ? Str::title($value) : $value,
        );
    }

    protected function name(): Attribute
    {
        return Attribute::make(
            get: fn (?string $value) => filled($value) ? Str::upper($value) : $value,
        );
    }

    protected function job(): Attribute
    {
        return Attribute::make(
            get: fn (?string $value) => filled($value) ? Str::ucfirst($value) : $value,
        );
    }

    protected function companyActivity(): Attribute
    {
        return Attribute::make(
            get: fn (?string $value) => filled($value) ? Str::ucfirst($value) : $value,
        );
    }

    protected function companyName(): Attribute
    {
        return Attribute::make(
            get: fn (?string $value) => filled($value) ? Str::upper($value) : $value,
        );
    }

    protected function companyCity(): Attribute
    {
        return Attribute::make(
            get: fn (?string $value) => filled($value) ? Str::upper($value) : $value,
        );
    }
}
