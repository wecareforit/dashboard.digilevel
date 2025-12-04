<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class ObjectMaintenances extends Model implements Auditable
{
    use SoftDeletes;
    use \OwenIt\Auditing\Auditable;
    // public $table = "object_inpection_zincodes";
    protected $fillable = ['code', 'description'];

    protected static function boot(): void
    {
        parent::boot();

        static::saving(function ($model) {
            //    $model->company_id = Filament::getTenant()->id;
        });

    }

}
