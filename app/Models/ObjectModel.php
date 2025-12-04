<?php
namespace App\Models;

use App\Models\Brand;
use App\Models\ObjectType;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class ObjectModel extends Model implements Auditable
{
    // use SoftDeletes;
    use \OwenIt\Auditing\Auditable;

    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

    public function category()
    {
        return $this->hasOne(ObjectType::class, 'id', 'type_id');
    }

}
