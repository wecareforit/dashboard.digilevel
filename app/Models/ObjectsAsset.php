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
class ObjectsAsset extends Model implements Auditable, HasMedia, HasCustomFields
{
    use HasFilamentComments;
    public $table = "objects";
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


    public function latestInspection()
    {
        return $this->hasOne(ElevatorInspection::class, 'object_id')->latest('end_date');
    }

    public function employee()
    {
        return $this->hasOne(Employee::class, 'id', 'employee_id');
    }


    public function employees()
    {

        return $this->hasMany(ObjectsDocument::class,'object_id')->where('status_id', '!=', 4);
    }

 
 


    public function location()
    {
        return $this->hasOne(relationLocation::class, 'id', 'location_id');
    }

    public function management()
    {
        return $this->hasOne(ObjectmanagementCompanies::class, 'id', 'management_id');
    }

    public function customer()
    {
        return $this->hasOne(Relation::class, 'id', 'customer_id');
    }

    public function supplier()
    {
        return $this->hasOne(Relation::class, 'id', 'supplier_id');
    }

    public function type()
    {
        return $this->hasOne(ObjectType::class, 'id', 'type_id');
    }

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }

    public function maintenance_company()
    {
        return $this->hasOne(Relation::class, 'id', 'maintenance_company_id');
    }


        public function tickets()
    {
        return $this->hasOne(assetToTicket::class, 'id', 'object_id');
    }


    public function inspectioncompany()
    {
        return $this->hasOne(Relation::class, 'id', 'inspection_company_id');
    }

    public function getAllElevatorOnThisAddressAttribute()
    {
        return Elevator::where('address_id', $this->attributes["address_id"])->get();
    }

    public function getifMonitoringAttribute()
    {
        if ($this->monitoring_object_id) {
            return 1;
        } else {
            return 0;

        }
    }

    public function inspections()
    {
        return $this->hasMany(ElevatorInspection::class, 'object_id', 'id')->orderby('end_date', 'desc');
    }

    public function inspection()
    {
        return $this->hasOne(ElevatorInspection::class, 'id', 'object_id')->orderBy('end_date', 'desc')->orderBy('executed_datetime', 'desc');
    }

    // protected static function boot(): void
    // {
    //     parent::boot();

    //     static::saving(function ($model) {
    //         $model->company_id = Filament::getTenant()->id;
    //     });

    // }

    public function features()
    {
        return $this->hasMany(ObjectFeatures::class, 'object_id', 'id');
    }

    public function documents()
    {
        return $this->hasMany(ObjectsDocument::class,'object_id');
    }


    


    public function uploads()
    {
        return $this->hasMany(Upload::class, 'item_id', 'id');
    }

    public function incidents()
    {
        return $this->hasMany(ObjectIncident::class,'object_id');
    }

    public function incident_stand_still()
    {
        return $this->hasOne(ObjectIncident::class, 'object_id')->where('standing_still', 1);
    }

    public function maintenance()
    {
        return $this->hasMany(ObjectMaintenances::class);
    }

    public function maintenance_contracts()
    {
        return $this->hasMany(ObjectMaintenanceContract::class);
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

    // public function getMonitoringConnectState(): ?string
    // {
    // $data = ObjectMonitoring::where('external_object_id', $this->monitoring_object_id)->where('category', 'connected')->select('value')->orderby('created_at', 'desc')->first();
    // switch ($data->value) {
    //     case '0':
    //         $text  = "Verbroken";
    //         $color = "warning";
    //         break;
    //     case '1':
    //         $text  = "Verbinding";
    //         $color = "success";
    //         break;
    //     case '2';
    //         $text  = "Foutmelding";
    //         $color = "danger";
    //         break;
    //     default:
    //         break;
    // }

    // $data = ['text' => $text, 'color' => $color];
    // return $data;

    // }

    public function getMonitoringConnectState()
    {
        return $this->hasOne(ObjectMonitoring::class, 'external_object_id', 'monitoring_object_id')->where('category', 'connected')->latest('created_at');
    }

    public function getMonitoringStateText()
    {
        switch ($this->getMonitoringConnectState?->value) {
            case '0':
                return "Offline";
                break;
            case '1':
                return "Online";
                break;
            case '2';
                return "Foutmelding";
                break;
            default:
                break;
        }

    }

    public function getMonitoringStateColor()
    {
        switch ($this->getMonitoringConnectState?->value) {
            case '0':
                return "warning";
                break;
            case '1':
                return "success";
                break;
            case '2';
                return "danger";
                break;
            default:
                break;
        }

    }

    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

    public function model()
    {
        return $this->belongsTo(ObjectModel::class);
    }

    public function assetToTickets()
    {
        return $this->hasMany(\App\Models\assetToTicket::class, 'object_id');
    }

}
