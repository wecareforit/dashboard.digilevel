<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Customer;
use App\Models\Building;
use Carbon\Carbon;
use OwenIt\Auditing\Contracts\Auditable;

class ObjectFeatures extends Model  implements Auditable
{
  //  use SoftDeletes;
    use \OwenIt\Auditing\Auditable;
 
    
    protected $fillable = [
        'name','address','zipcode','phonenumber','email','place','active'
    ];

    
    public function feature()
    {
        return $this->hasOne(Feature::class,'id','feature_id');
    }


}
