<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class Upload extends Model implements Auditable
{
    use HasFactory;
    use \OwenIt\Auditing\Auditable;
    protected $fillable = [
        'type',
        'filename',
        'object_id',
        'add_by_user_id',
        'incident_id',
        'relation_id',
        'type_id',
        'path',
        'group_id',
        'title',
    ];

    public function type()
    {
        return $this->hasOne(uploadType::class, 'id', 'upload_type_id');
    }

    protected static function boot(): void
    {
        parent::boot();
        static::saving(function ($model) {
            // $model->company_id = Filament::getTenant()->id;     $model->company_id = Filament::getTenant()->id;
        });

    }

}
