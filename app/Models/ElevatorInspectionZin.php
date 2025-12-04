<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ElevatorInspectionZin extends Model
{
    use HasFactory;
    public $table = 'elevator_inpection_zincodes';
    /**
     * @var string[]
     */
  
}
