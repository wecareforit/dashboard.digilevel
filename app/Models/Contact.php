<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Parallax\FilamentComments\Models\Traits\HasFilamentComments;
use Relaticle\CustomFields\Models\Concerns\UsesCustomFields;
use Relaticle\CustomFields\Models\Contracts\HasCustomFields;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Enums\ContactTypes;
class Contact extends Model implements HasCustomFields
{
    use HasFactory;
    use HasFilamentComments;
    use UsesCustomFields;
        use SoftDeletes;
    /**
     * @var string[]
     */
    protected $casts = [
        'metadata' => 'collection',
        'type' => ContactTypes::class,
    ];

 

    protected $appends = ['avatar'];

    protected $fillable = ['first_name', 'last_name', 'email', 'department', 'function', 'phone_number', 'mobile_number'];

    // public function company(): BelongsTo
    // {
    //     return $this->belongsTo(Company::class);
    // }

    // public function newQuery()
    // {
    //     return parent::newQuery()->where('type_id', 2);
    // }

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
    // If user uploaded an avatar
    if ($this->image) {
        return "/storage/" . $this->image;
    }

    // Otherwise generate initials
    $initials = '';
    if ($this->first_name) {
        $initials .= strtoupper(substr($this->first_name, 0, 1));
    }
    if ($this->last_name) {
        $initials .= strtoupper(substr($this->last_name, 0, 1));
    }

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
        return $this->hasMany(Project::class);
    }

    public function location(): BelongsTo
    {
        return $this->belongsTo(Location::class,'location_id','id');
    }

    public function supplier(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }

    public function claimer(): MorphTo
    {
        return $this->morphTo();
    }

    public function relationsObject()
    {
        return $this->hasMany(ContactObject::class, 'contact_id', 'id');
    }

    

}
