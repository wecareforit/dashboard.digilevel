<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class Customer extends Model implements Auditable
{
    // use HasFactory;
    use SoftDeletes;

    use \OwenIt\Auditing\Auditable;

    protected $table = 'customers';

    public function locations()
    {
        return $this->hasMany(ObjectLocation::class, 'customer_id', 'id');
    }

    public function objects()
    {
        return $this->hasMany(ObjectsAsset::class, 'customer_id', 'id');
    }

    public function users()
    {
        return $this->hasMany(User::class, 'customer_id', 'id');
    }

    public function type()
    {
        return $this->hasOne(RelationType::class);
    }

    protected $fillable = [
        'name', 'address', 'zipcode', 'phonenumber', 'emailaddress', 'place', 'phonenumber', 'slug',
    ];

}
