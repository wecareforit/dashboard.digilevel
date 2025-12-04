<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;
//Geen
use Carbon\Carbon;
 
class ToolsType extends Model implements Auditable
{
    use SoftDeletes;
    use \OwenIt\Auditing\Auditable;
    
    protected $fillable = [
        'name','category_id','brand_id'
    ];
    // protected $fillable = [
   //     'last_action_at',
    // /    'code',
   //     'location_id',
    // ];

    ///protected $appends = ['location_name'];


    public function brand(){
        return $this->belongsTo(toolsBrand::class);
    }


    public function category(){
        return $this->hasOne(toolsCategory::class,'id','category_id');
    }


}



 