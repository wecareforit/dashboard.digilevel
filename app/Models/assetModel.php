<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class AssetModel extends Model
{
    use HasFactory;

    /**
     * @var string[]
     */
    protected $casts = [
        'metadata' => 'collection',
    ];

    public function brand(): BelongsTo
    {
        return $this->belongsTo(assetBrand::class, 'brand_id');
    }

    public function category()
    {
        return $this->hasOne(ObjectType::class, 'id', 'type_id');
    }

    public function assets(): HasMany
    {
        return $this->hasMany(Asset::class);
    }
}
