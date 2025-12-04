<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class ObjectInspectionData extends Model implements Auditable
{
    use SoftDeletes;
    use \OwenIt\Auditing\Auditable;

    protected $fillable = ['code', 'description'];

    public function elevator()
    {
        return $this->belongsTo(Feature::class);
    }

    protected static function boot(): void
    {
        parent::boot();
        static::saving(function ($model) {
            // $model->company_id = Filament::getTenant()->id;    $model->company_id = Filament::getTenant()->id;
        });

    }

}
