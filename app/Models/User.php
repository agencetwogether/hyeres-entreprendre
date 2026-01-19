<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Enums\Role;
use App\Settings\GeneralSettings;
use Filament\Models\Contracts\FilamentUser;
use Filament\Models\Contracts\HasAvatar;
use Filament\Models\Contracts\HasName;
use Filament\Panel;
use Illuminate\Database\Eloquent\Attributes\Scope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Spatie\Permission\Traits\HasRoles;
use Yebor974\Filament\RenewPassword\Contracts\RenewPasswordContract;
use Yebor974\Filament\RenewPassword\Traits\RenewPassword;

class User extends Authenticatable implements FilamentUser, HasAvatar, HasMedia, HasName, RenewPasswordContract
{
    use HasFactory, HasRoles, HasUlids, InteractsWithMedia, Notifiable, RenewPassword;

    protected $with = ['media'];

    protected $fillable = [
        'name',
        'firstname',
        'phone',
        'email',
        'password',
        'is_active',
        'want_notify',
        'force_renew_password',
        'last_logged_at',
    ];

    protected $hidden = [
        'id',
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
            'want_notify' => 'boolean',
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'last_logged_at' => 'datetime',
        ];
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
    /**
     * @return HasMany<Post>
     */
    public function posts(): HasMany
    {
        return $this->hasMany(Post::class, 'author_id');
    }

    /**
     * @return HasOne<Member>
     */
    public function member(): HasOne
    {
        return $this->hasOne(Member::class);
    }

    /*
    |--------------------------------------------------------------------------
    | UTILITIES
    |--------------------------------------------------------------------------
    */
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
    }

    public function isNotifiable(): bool
    {
        return $this->want_notify;
    }

    public function isSuperAdmin(): bool
    {
        return $this->hasRole(Role::SUPERADMIN);
    }

    public function isAdmin(): bool
    {
        return $this->hasRole(Role::ADMIN);
    }

    public function isMember(): bool
    {
        return $this->hasRole(Role::MEMBER);
    }

    /*
    |--------------------------------------------------------------------------
    | SCOPES
    |--------------------------------------------------------------------------
    */
    #[Scope]
    protected function active(Builder $query): void
    {
        $query->where('is_active', 1);
    }

    #[Scope]
    protected function superAdmin(Builder $query): void
    {
        $query->role(Role::SUPERADMIN);
    }

    #[Scope]
    protected function admin(Builder $query): void
    {
        $query->role(Role::ADMIN);
    }

    #[Scope]
    protected function wantsNotify(Builder $query): void
    {
        $query
            ->where('is_active', 1)
            ->where('want_notify', 1);
    }

    /*
    |--------------------------------------------------------------------------
    | ACCESSORS
    |--------------------------------------------------------------------------
    */
    protected function fullName(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->getFilamentName(),
        );
    }

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

    /*
    |--------------------------------------------------------------------------
    | MUTATORS
    |--------------------------------------------------------------------------
    */
    protected function email(): Attribute
    {
        return Attribute::make(
            set: fn (?string $value) => filled($value) ? Str::lower($value) : $value,
        );
    }

    /*
    |--------------------------------------------------------------------------
    | FILAMENT
    |--------------------------------------------------------------------------
    */
    public function canAccessPanel(Panel $panel): bool
    {
        return true;

        return match ($panel->getId()) {
            'admin' => $this->isSuperAdmin() || $this->isAdmin(),
            'member' => $this->isMember(),
            default => false,
        };
    }

    public function getFilamentName(): string
    {
        if (filled($this->firstname)) {

            return $this->firstname.' '.$this->name;

        }

        return $this->name;
    }

    public function getFilamentAvatarUrl(): ?string
    {
        return $this->getFirstMediaUrl('avatar', 'webp');
    }
}
