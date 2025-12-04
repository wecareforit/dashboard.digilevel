<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class relationType extends Model implements Auditable
{
    use SoftDeletes;

    use \OwenIt\Auditing\Auditable;
    public $table = "relation_types";

    protected $casts = [
        'options' => 'array',
    ];

    protected $fillable = [
        'name',
        'is_active',
        'sort',

    ];

    public function companies()
    {
        return $this->hasMany(Company::class, 'type_Id', 'id');
    }

}
