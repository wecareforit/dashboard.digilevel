<?php
namespace App\Models;

use Filament\Facades\Filament;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Product extends Model
{
    use HasFactory;

    /**
     * @var string[]
     */
    protected $casts = [
        'metadata' => 'collection',
    ];

    protected $appends = ['avatar'];

    protected $fillable = ['first_name', 'last_name', 'email', 'department', 'function', 'phone_number', 'mobile_number'];

   
}
