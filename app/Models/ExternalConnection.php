<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class externalConnection extends Model
{
    use HasFactory;
    public $table = "external";

    // Attributes that should be mass-assignable
    protected $fillable = ['module_id',
        'token_1',
        'token_2',
        'token_3'
        , 'token_4'
        , 'last_success_datetime'
        , 'last_error_datetime', 'last_action_datetime'
        , 'status_id'
        , 'company_id'
        , 'from_date'
        , 'relation_id',
    ];

    // protected static function booted(): void
    // {
    //     static::addGlobalScope(function ($query) {
    //         $query;
    //     });
    // }

    // protected static function boot(): void
    // {
    //     parent::boot();

    //     static::saving(function ($model) {
    //         $model->company_id = Filament::getTenant()->id;
    //     });

    // }

    public function relation()
    {
        return $this->belongsTo(Relation::class);
    }

    public function lastLog()
    {
        return $this->hasOne(ExternalApiLog::class, 'external_id', 'id')->orderBy('created_at', 'desc');
    }

}
