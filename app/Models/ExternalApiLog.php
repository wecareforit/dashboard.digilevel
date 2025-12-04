<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Customer;
use App\Models\Building;
use Carbon\Carbon;
use App\Enums\ApiStatus;
 

class ExternalApilog extends Model  
{   

    
    protected function casts(): array
    {
        return [
            'status_id' => ApiStatus::class,
          
        ];
    }


    protected $fillable = [
        'model'
    ];
}
