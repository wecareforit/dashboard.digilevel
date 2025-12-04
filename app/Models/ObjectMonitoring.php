<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ObjectMonitoring extends Model
{
    public $table = 'object_monitoring';

    protected $fillable = [
        'external_object_id',
        'category',
        'param01',
        'param02',
        'value',
        'date_time',
        'brand',
    ];

    public function error()
    {
        return $this->belongsTo(ObjectMonitoringCode::class, 'value', 'error_code');
    }

}
