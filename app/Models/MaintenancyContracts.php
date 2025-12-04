<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;
use Carbon\Carbon;

class MaintenancyContracts extends Model implements Auditable
{
    use SoftDeletes;
    use \OwenIt\Auditing\Auditable;

    protected $fillable = ['option1','option2', 'option3','type_id','document', 'begindate','enddate' ,'object_id','maintenancy_companie_id'];

    protected $appends = [];

protected $table = 'maintenance_contracts';


protected $casts = [
       'options' => 'array',
   ];


   
   public function maintenancecompany()
    {
        return $this->hasOne(maintenanceCompany::class, 'id', 'maintenancy_companie_id');
    }


    //  public function getaddressAttribute()
    // {
    //if ($this->attributes["address_id"]) {
       //     return Address::find($this->attributes["address_id"]);
    // }
    // }
}
