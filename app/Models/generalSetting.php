<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class generalSetting extends Model
{

    // Define the table name if it's not the plural of the model name
    protected $table      = 'general_settings';
    protected $connection = 'mysql';
}
