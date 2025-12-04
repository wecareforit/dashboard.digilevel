<?php
namespace App\Models;

use App\Enums\QuoteStatus;
use App\Enums\QuoteTypes;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class Quote extends Model implements Auditable
{
    use SoftDeletes;
    use \OwenIt\Auditing\Auditable;

    protected function casts(): array
    {
        return [
            'type_id'   => QuoteTypes::class,
            'status_id' => QuoteStatus::class,
        ];
    }

    // Attributes that should be mass-assignable
    protected $fillable = ['number', 'type'];

    public function project()
    {
        return $this->hasOne(Project::class, 'id', 'project_id');
    }

    public function supplier()
    {
        return $this->hasOne(Relation::class, 'id', 'company_id');
    }

}
