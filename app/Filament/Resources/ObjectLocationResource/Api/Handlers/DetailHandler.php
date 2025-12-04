<?php

namespace App\Filament\Resources\ObjectLocationResource\Api\Handlers;

use App\Filament\Resources\SettingResource;
use App\Filament\Resources\ObjectLocationResource;
use Rupadana\ApiService\Http\Handlers;
use Spatie\QueryBuilder\QueryBuilder;
use Illuminate\Http\Request;
use App\Filament\Resources\ObjectLocationResource\Api\Transformers\ObjectLocationTransformer;

class DetailHandler extends Handlers
{
    public static string | null $uri = '/{id}';
    public static string | null $resource = ObjectLocationResource::class;


    /**
     * Show ObjectLocation
     *
     * @param Request $request
     * @return ObjectLocationTransformer
     */
    public function handler(Request $request)
    {
        $id = $request->route('id');
        
        $query = static::getEloquentQuery();

        $query = QueryBuilder::for(
            $query->where(static::getKeyName(), $id)
        )
            ->first();

        if (!$query) return static::sendNotFoundResponse();

        return new ObjectLocationTransformer($query);
    }
}
