<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

use Carbon\Carbon;
 
class ToolsBrand extends Model implements Auditable
{
    use SoftDeletes;
    use \OwenIt\Auditing\Auditable;
    
    // protected $fillable = [
    //     'name','is_active'
    // ];
     protected $fillable = [
    'name',
     'is_active',
         'image'
     ];

    ///protected $appends = ['location_name'];
}



  