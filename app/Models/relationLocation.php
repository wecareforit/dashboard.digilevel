<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;
use Parallax\FilamentComments\Models\Traits\HasFilamentComments;
use Relaticle\CustomFields\Models\Concerns\UsesCustomFields;
use Relaticle\CustomFields\Models\Contracts\HasCustomFields;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Illuminate\Support\Facades\Cache;

/**

 * @package App
 * @mixin Builder
 */
class relationLocation extends Model implements Auditable, HasMedia, HasCustomFields
{
    use SoftDeletes;
    use InteractsWithMedia;
    use \OwenIt\Auditing\Auditable;
    use HasFilamentComments;
 

    use UsesCustomFields;
    // protected function casts(): array
    // {
    //     return [
    //         'type_id' => LocationType::class,

    //     ];
    // }

 
    
    public function registerMediaCollections(): void
    {

        $tenant = Cache::get('tenant');
$tenantDisk = 'tenant_' . $tenant->code;
        $this->addMediaCollection('relationlocationimages')
            ->useDisk($tenantDisk) 
            ->singleFile();

            
    }

 
    
    // Validation rules for this model
    static $rules = [];

    // Number of items to be shown per page
    protected $perPage = 20;

    public function objects()
    {
        return $this->hasMany(ObjectsAsset::class, 'location_id', 'id');
    }

 

    public function relation()
    {
        return $this->belongsTo(Relation::class);
    }

    public function tickets()
    {
        return $this->hasMany(Ticket::class, 'location_id', 'id');
    }

    public function contactsObject()
    {
        return $this->hasMany(Contact::class, 'location_id', 'id');
    }

    public function notes()
    {
        return $this->hasMany(Note::class, 'item_id', 'id')->where('model', 'RelationLocation');
    }

    public function attachments()
    {
        return $this->hasMany(Attachment::class, 'item_id', 'id')->where('model', 'RelationLocation');
    }

    public function buildingtype()
    {
        return $this->belongsTo(ObjectBuildingType::class, 'building_type_id', 'id');
    }

    public function type()
    {
        return $this->belongsTo(locationType::class);
    }

    public function management()
    {
        return $this->belongsTo(Relation::class);
    }

    public function getFullAddress(): ?string
    {

        return collect([$this->address, $this->zipcode, $this->place])->filter()->implode(' ');
    }
}
