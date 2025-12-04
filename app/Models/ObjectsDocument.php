<?php
namespace App\Models;

use App\Enums\ElevatorStatus;
use App\Enums\InspectionStatus;
 
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;
use Parallax\FilamentComments\Models\Traits\HasFilamentComments;
use Relaticle\CustomFields\Models\Concerns\UsesCustomFields;
use Relaticle\CustomFields\Models\Contracts\HasCustomFields;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
 use App\Enums\ObjectDocumentStatus;
class ObjectsDocument extends Model implements Auditable, HasMedia, HasCustomFields
{
    use HasFilamentComments;
 
    use InteractsWithMedia;
    use SoftDeletes;

    use UsesCustomFields;
      public $table = "object_documents";
    use \OwenIt\Auditing\Auditable;

     public function employee(){
         return $this->hasOne(Employee::class, 'id', 'employee_id');
     }


    protected function casts(): array
    {
        return [
            'status_id'                    => ObjectDocumentStatus::class,
        ];
    }


    // protected static function boot(): void
    // {
    //     parent::boot();

    //     static::saving(function ($model) {
    //         $model->company_id = Filament::getTenant()->id;
    //     });

    // }

    
 

}
