<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
 
use OwenIt\Auditing\Contracts\Auditable;
 

 
 


class uploadType extends Model implements Auditable
 
{
    

 protected $casts = [
        'visable_module' => 'array',
    ];
 
     use SoftDeletes;
    use \OwenIt\Auditing\Auditable;
 
    // Validation rules for this model
    static $rules = [];

    // Number of items to be shown per page
    protected $perPage = 20;

    protected $fillable = [
        'name','visible_projects'

        ,'visible_incidents'
        ,'visible_assets'
        ,'visible_tools'
        ,'visible_workorders'
        ,'visible_fleet'
        ,'visible_object_management_companies'
        ,'visible_object_suppliers'
        ,'visible_object_maintenance_companies'
    ];




}
