<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ObjectMonitoringCode extends Model
{
    use SoftDeletes;
    public $table = 'object_monitoring_codes';

}
