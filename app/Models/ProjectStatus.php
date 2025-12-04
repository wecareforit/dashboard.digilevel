<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;
use Illuminate\Support\Facades\Auth;

use App\Models\Project;

class ProjectStatus extends Model implements Auditable
{
    use SoftDeletes;
    use \OwenIt\Auditing\Auditable;





    // Attributes that should be mass-assignable
    protected $fillable = ['name','is_active'];





}



