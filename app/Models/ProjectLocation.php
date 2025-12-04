<?php

namespace App\Models;

use Filament\Actions\Concerns\HasLabel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class ProjectLocation extends Model implements Auditable
{
    use SoftDeletes;
    use \OwenIt\Auditing\Auditable;
    use HasLabel;


    // Attributes that should be mass-assignable
    protected $fillable = ['location_id','project_id'];





}
