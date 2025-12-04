<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class assetToTicket extends Model
{
    use HasFactory;

    /**
     * @var string[]
     */

    public function object()
    {
        return $this->hasOne(ObjectsAsset::class, 'id', 'object_id');
    }

}
