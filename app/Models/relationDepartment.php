<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**

 * @package App
 * @mixin Builder
 */
class relationDepartment extends Model
{
    use SoftDeletes;
    public function location()
    {
        return $this->hasOne(relationLocation::class, 'id', 'relation_location_id');
    }
}
