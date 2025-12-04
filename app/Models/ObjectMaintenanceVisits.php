<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class ObjectMaintenanceVisits extends Model implements Auditable
{
    use SoftDeletes;
    use \OwenIt\Auditing\Auditable;
    // public $table = "object_inpection_zincodes";

    protected $fillable = ['code', 'description'];

    public function elevator()
    {
        return $this->belongsTo(ObjectsAsset::class,'object_id');
    }

    public function maintenance_company()
    {
        return $this->hasOne(Relation::class, 'id', 'maintenance_company_id');
    }

    protected static function boot(): void
    {
        parent::boot();

        static::saving(function ($model) {
            //   $model->company_id = Filament::getTenant()->id;
        });

    }
}
