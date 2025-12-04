<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;
use Parallax\FilamentComments\Models\Traits\HasFilamentComments;
use Relaticle\CustomFields\Models\Concerns\UsesCustomFields;

class Employee extends Model implements Auditable
{
    use SoftDeletes;
    use UsesCustomFields;
    use HasFilamentComments;
    use \OwenIt\Auditing\Auditable;
    public $table = "contacts";
    //  protected $fillable = ['name', 'is_active'];

    public function getNameAttribute()
    {
        return $this->first_name . " " . $this->last_name;

    }
    public function getAvatarAttribute($value)
    {
        if ($this->image) {
            return $this->image;
        } else {
            return '/images/noavatar.jpg';
        }
    }

/**
 * Get a new query builder for the model's table.
 *
 * @return \Illuminate\Database\Eloquent\Builder
 */
    public function newQuery()
    {
        return parent::newQuery()->where('type_id', 1);
    }

    public function relation()
    {
        return $this->hasOne(Relation::class, 'id', 'relation_id');
    }

    public function projects(): HasMany
    {
        return $this->hasMany(Project::class, 'contact_id', 'id');

    }
    public function department()
    {
        return $this->hasOne(relationDepartment::class, 'id', 'department_id');
    }

// In your Employee model
    public function user()
    {
        return $this->belongsTo(User::class)->withDefault();
    }
}
