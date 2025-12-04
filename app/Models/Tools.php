<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class Tools extends Model implements Auditable
{
    use SoftDeletes;
    use \OwenIt\Auditing\Auditable;

    protected $fillable = [
        'description', 'serial_number', 'employee_id', 'warehouse_id', 'inspection_interval', 'name', 'brand_id', 'category_id', 'supplier_id', 'type_id', 'image', 'inspection_company_id', 'inspection_method',
    ];

    protected static function boot(): void
    {
        parent::boot();

        static::saving(function ($model) {
            //      $model->company_id = Filament::getTenant()->id;
        });

    }

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function brand()
    {
        return $this->belongsTo(toolsBrand::class);
    }

    public function category()
    {
        return $this->belongsTo(toolsCategory::class);
    }
    public function supplier()
    {
        return $this->belongsTo(toolsSupplier::class);
    }

    public function type()
    {
        return $this->belongsTo(toolsType::class);
    }

    public function warehouse()
    {
        return $this->belongsTo(warehouse::class);
    }

    public function employee()
    {
        return $this->belongsTo(User::class);
    }

}
