<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Parallax\FilamentComments\Models\Traits\HasFilamentComments;
use Relaticle\CustomFields\Models\Concerns\UsesCustomFields;
use Relaticle\CustomFields\Models\Contracts\HasCustomFields;

class allContact extends Model implements HasCustomFields
{
    use HasFactory;
    use HasFilamentComments;
    use UsesCustomFields;
    public $table = "contacts";

    /**
     * @var string[]
     */
    protected $casts = [
        'metadata' => 'collection',
    ];

    protected $appends = ['avatar'];

    protected $fillable = ['first_name', 'last_name', 'email', 'department', 'function', 'phone_number', 'mobile_number'];

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }

    public function newQuery()
    {
        return parent::newQuery()->where('type_id', 2);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(AssetCategory::class);
    }

    public function type()
    {
        return $this->belongsTo(contactType::class);
    }

    public function department()
    {
        return $this->hasOne(relationDepartment::class, 'id', 'department_id');
    }

    public function getAvatarAttribute($value)
    {
        // if ($this->image) {
        //    return $this->image;
        //  } else {
        return '/images/noavatar.jpg';
        //  }
    }

    public function getNameAttribute()
    {
        return $this->first_name . " " . $this->last_name;

    }

    public function relation()
    {
        return $this->hasOne(Relation::class, 'id', 'relation_id');
    }

    public function projects(): HasMany
    {
        return $this->hasMany(Project::class, 'contact_id');
    }

    public function location(): BelongsTo
    {
        return $this->belongsTo(Location::class);
    }

}
