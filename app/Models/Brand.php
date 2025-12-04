<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
    use HasFactory;

    // public function company(): BelongsTo
    // {
    //     return $this->belongsTo(Company::class);
    // }

    public function models()
    {
        return $this->hasMany(ObjectModel::class, 'brand_id');
    }
}
