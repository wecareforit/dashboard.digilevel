<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class external extends Model
{
    use HasFactory;
    use SoftDeletes;

    public $table = "external";

    protected $fillable = [
        'module_id',
        'is_active',
        'token_1',
        'token_2',
        'password',
       

    ];
}
