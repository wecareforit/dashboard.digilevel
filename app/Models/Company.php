<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Models\Activity;
use Spatie\Activitylog\Traits\LogsActivity;

class Company extends Model
{
    use HasFactory, LogsActivity;

    protected $fillable = [
        'name',
    ];

    public function departments(): HasMany
    {
        return $this->hasMany(Department::class);
    }

    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }

    public function companyUsers(): HasMany
    {
        return $this->hasMany(CompanyUsers::class);
    }

    public function vehicles(): HasMany
    {
        return $this->hasMany(Vehicle::class);
    }

    public function contacts(): HasMany
    {
        return $this->hasMany(Contact::class);
    }

    public function tasks(): HasMany
    {
        return $this->hasMany(Task::class);
    }

    public function tools(): HasMany
    {
        return $this->hasMany(Tools::class);
    }

    public function activities()
    {
        return $this->morphMany(Activity::class, 'causer'); // ✅ Corrected
    }

    public function gpsObjects()
    {
        return $this->hasMany(gpsObject::class);
    }

    public function relations()
    {
        return $this->hasMany(Relation::class);
    }

    public function mailboxes()
    {
        return $this->hasMany(Mailbox::class);
    }

    public function elevators()
    {
        return $this->hasMany(ObjectsAsset::class);
    }

    public function objectLocations()
    {
        return $this->hasMany(ObjectLocation::class);
    }

    public function externalConnection()
    {
        return $this->hasMany(ExternalConnection::class);
    }

    public function locations()
    {
        return $this->hasMany(Location::class);
    }
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['name'])
            ->logOnlyDirty()
            ->useLogName('company');
    }
}
