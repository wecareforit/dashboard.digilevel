<?php
namespace App\Models;

use App\Enums\ElevatorStatus;

 use App\Models\ObjectsDocument;
use App\Enums\InspectionStatus;
use App\Models\ElevatorInspection;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;
use Parallax\FilamentComments\Models\Traits\HasFilamentComments;
use Relaticle\CustomFields\Models\Concerns\UsesCustomFields;
use Relaticle\CustomFields\Models\Contracts\HasCustomFields;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

/**
 * Class ManagementCompany
 *
 * @property $id
 * @property $created_at
 * @property $updated_at
 * @property $deleted_at
 * @property $last_edit_at
 * @property $last_edit_by
 * @property $name
 * @property $zipcode
 * @property $place
 * @property $address
 * @property $general_emailaddress
 * @property $phonenumber
 *
 * @package App
 * @mixin Builder
 */
class Elevator extends Model implements Auditable, HasMedia, HasCustomFields
{
    use HasFilamentComments;
    use InteractsWithMedia;
    use SoftDeletes;
    use UsesCustomFields;
    protected function casts(): array
    {
        return [
            'status_id'                    => ElevatorStatus::class,
            'current_inspection_status_id' => InspectionStatus::class,

        ];
    }
    static $rules = [];
    use \OwenIt\Auditing\Auditable;

    protected $fillable = [
        'status_id', 'energy_label', 'customer_id', 'management_id', 'inspection_state_id', 'supplier_id', 'remark', 'address_id', 'inspection_company_id', 'maintenance_company_id', 'stopping_places', 'carrying_capacity', 'energy_label', 'stretcher_elevator', 'fire_elevator', 'object_type_id', 'construction_year', 'nobo_no', 'name', 'unit_no',
    ];

  public function inspectioncompany()
    {
        return $this->hasOne(Relation::class, 'id', 'inspection_company_id');
    }

        public function latestInspection()
    {
        return $this->hasOne(ElevatorInspection::class, 'object_id')->latest('end_date');
    }


    
       public function maintenance_company()
    {
        return $this->hasOne(Relation::class, 'id', 'maintenance_company_id');
    }

 public function maintenance()
    {
        return $this->hasMany(ObjectMaintenances::class);
    }

    public function maintenance_contracts()
    {
        return $this->hasMany(ObjectMaintenanceContract::class,'id', 'object_id');
    }

    public function maintenance_visits()
    {
        return $this->hasMany(ObjectMaintenanceVisits::class);
    }

    //Monitoring

    public function getMonitoringLastInsert()
    {
        return $this->hasOne(ObjectMonitoring::class, 'external_object_id', 'monitoring_object_id')->latest();
    }

    public function getMonitoringVersion()
    {
        return $this->hasOne(ObjectMonitoring::class, 'external_object_id', 'monitoring_object_id')->where('category', 'version')->latest('date_time');
    }

    public function getMonitoringType()
    {
        return $this->hasOne(ObjectMonitoring::class, 'external_object_id', 'monitoring_object_id')->where('category', 'type')->latest('date_time');
    }


        public function inspections()
    {
        return $this->hasMany(ElevatorInspection::class, 'nobo_number', 'nobo_no')->orderby('end_date', 'desc');
    }

    public function inspection()
    {
        return $this->hasOne(ElevatorInspection::class, 'id', 'object_id')->orderBy('end_date', 'desc')->orderBy('executed_datetime', 'desc');
    }

    
    public function uploads()
    {
        return $this->hasMany(Upload::class, 'item_id', 'id');
    }


    public function getMonitoringFloor()
    {
        return $this->hasOne(ObjectMonitoring::class, 'external_object_id', 'monitoring_object_id')->where('category', 'stop')->latest('date_time');
    }

    public function getMonitoringEvents()
    {
        return $this->hasMany(ObjectMonitoring::class, 'external_object_id', 'monitoring_object_id')->whereIn('category', ['doors', 'moving', 'online', 'floor', 'direction', 'state', 'error', 'speed']);
    }

    public function getMonitoringEventCount()
    {
        return $this->hasMany(ObjectMonitoring::class, 'external_object_id', 'monitoring_object_id')->count();
    }


     public function incidents()
    {
        return $this->hasMany(ObjectIncident::class,'object_id');
    }

    public function incident_stand_still()
    {
        return $this->hasOne(ObjectIncident::class,'object_id')->where('standing_still', 1);
    }



    public function location()
    {
        return $this->hasOne(relationLocation::class, 'id', 'location_id');
    }


}
