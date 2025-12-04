<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class AssetCategory extends Model
{
    use HasFactory;

    /**
     * @var string[]
     */
    protected $casts = [
        'metadata' => 'collection',
    ];

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }

    public function parent(): BelongsTo
    {
        return $this->belongsTo(AssetCategory::class);
    }

    public function subCategories(): HasMany
    {
        return $this->hasMany(AssetCategory::class, 'parent_id');
    }

    public function brands(): HasMany
    {
        return $this->hasMany(assetBrand::class);
    }
}
