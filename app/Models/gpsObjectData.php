<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class gpsObjectData extends Model implements Auditable
{
    use SoftDeletes;
    use \OwenIt\Auditing\Auditable;

    protected $fillable = [
        'company_id',
    ];
    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }

    protected static function boot(): void
    {
        parent::boot();

        static::saving(function ($model) {
            //  $model->company_id = Filament::getTenant()->id;
            $model->params_acc = 0;
        });

    }

}
