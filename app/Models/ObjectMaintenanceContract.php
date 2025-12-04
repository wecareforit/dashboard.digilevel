<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class ObjectMaintenanceContract extends Model implements Auditable
{
    use SoftDeletes;
    use \OwenIt\Auditing\Auditable;
    public $table       = "object_maintenance_contracts";
    protected $fillable = ['code', 'description'];

    protected static function boot(): void
    {
        parent::boot();

        static::saving(function ($model) {
            //     $model->company_id = Filament::getTenant()->id;
        });

    }

    public function maintenance_company()
    {
        return $this->hasOne(Relation::class, 'id', 'maintenance_company_id');
    }

}
