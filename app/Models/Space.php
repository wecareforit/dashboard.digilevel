<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Space extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
    ];

    public function location()
    {
        return $this->hasOne(Location::class, 'id', 'location_id');
    }

    public function department()
    {
        return $this->hasOne(department::class, 'id', 'department_id');
    }

}
