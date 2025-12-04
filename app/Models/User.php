<?php
namespace App\Models;

use Filament\Models\Contracts\FilamentUser;
use Filament\Models\Contracts\HasAvatar;
use Filament\Panel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Rappasoft\LaravelAuthenticationLog\Traits\AuthenticationLoggable;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Models\Activity;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Permission\Traits\HasRoles;
use Stephenjude\FilamentTwoFactorAuthentication\TwoFactorAuthenticatable;
 use JaysonTemporas\PageBookmarks\Traits\HasBookmarks;
use Illuminate\Support\Facades\Storage;
use Stancl\Tenancy\Database\Concerns\BelongsToTenant;

class User extends Authenticatable implements FilamentUser, HasAvatar
{
    use HasBookmarks,HasFactory, Notifiable, LogsActivity, TwoFactorAuthenticatable, HasApiTokens, HasRoles, AuthenticationLoggable;
  
    // public function newQuery()
    // {
    //     return parent::newQuery()->whereNot('id', 1);
    // }

    public function canAccessPanel(Panel $panel): bool
    {

        if ($panel->getId() === 'app') {
            return true;
        }

        if ($panel->getId() === 'admin') {
            return str_ends_with($this->email, '@ltssoftware.nl');
        }

    }

    public function canImpersonate()
    {
        return true;
    }

    // public function canBeImpersonated()
    // {

    //     return true;
    //     // return str_ends_with($this->email, '@ltssoftware.nl');
    // }

    // public function getFilamentAvatarUrl(): ?string
    // {
    //     $avatarColumn = config('filament-edit-profile.avatar_column', 'avatar_url');
    //     return $this->$avatarColumn ? Storage::url("$this->$avatarColumn") : null;
    // }
    public function getFilamentAvatarUrl(): ?string
   {
        $avatarColumn = config('filament-edit-profile.avatar_column', 'avatar_url');
        return $this->$avatarColumn ? Storage::url($this->$avatarColumn) : null;
    }
    // public function getTenantIdLabel(): string
    // {
    //     return Filament::getTenant()->id;
    // }

    // public function getCurrentId(): string
    // {
    //     return 'Active team';
    // }

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'avatar_url',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password'          => 'hashed',
        ];
    }

    // public function getAvatarAttribute($value)
    // {
    //     if ($this->image) {
    //         return "/storage/" . $this->avatar_url;
    //     } else {
    //         return '/images/noavatar.jpg';
    //     }

    // }
 



 public function getAvatarAttribute($value)
{
    // If user uploaded an avatar
    if ($this->image) {
        return "/storage/" . $this->image;
    }
$parts = preg_split('/\s+/', trim($this->name));
    if (!$parts) {
        return '';
    }

    // first letter of first and last part (if exists)
    $first = mb_substr($parts[0], 0, 1);
    $last  = count($parts) > 1 ? mb_substr($parts[count($parts) - 1], 0, 1) : '';

    $initials = mb_strtoupper($first . $last);

    // Pick a background color (you can randomize or hash the user ID for consistency)
    $colors = ['#1abc9c', '#3498db', '#9b59b6', '#e67e22', '#e74c3c'];
    $bgColor = $colors[$this->id % count($colors)]; // consistent color per user

    // Encode initials as URL for a small SVG avatar
    $svg = '<svg xmlns="http://www.w3.org/2000/svg" width="128" height="128">
        <rect width="100%" height="100%" fill="' . $bgColor . '"/>
        <text x="50%" y="50%" dominant-baseline="middle" text-anchor="middle" 
              font-family="Arial, Helvetica, sans-serif" font-size="48" fill="#ffffff">' 
              . $initials . '</text>
    </svg>';

    $encoded = 'data:image/svg+xml;base64,' . base64_encode($svg);

    return $encoded;
}


    public function activities()
    {
        return $this->morphMany(Activity::class, 'causer'); // ✅ Corrected
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['name'])
            ->logOnlyDirty()
            ->useLogName('user');
    }

    // public function companies(): BelongsToMany
    // {
    //     return $this->belongsToMany(Company::class);
    // }

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }

    // public function getTenants(Panel $panel): array | Collection
    // {
    //     return $this->companies;
    // }

    // public function canAccessTenant(Model $tenant): bool
    // {
    //     return $this->companies()->whereKey($tenant)->exists();
    // }

}
