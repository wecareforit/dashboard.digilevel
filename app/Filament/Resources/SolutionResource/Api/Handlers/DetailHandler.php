<?php

namespace App\Filament\Resources\SolutionResource\Api\Handlers;

use App\Filament\Resources\SettingResource;
use App\Filament\Resources\SolutionResource;
use Rupadana\ApiService\Http\Handlers;
use Spatie\QueryBuilder\QueryBuilder;
use Illuminate\Http\Request;
use App\Filament\Resources\SolutionResource\Api\Transformers\SolutionTransformer;

class DetailHandler extends Handlers
{
    public static string | null $uri = '/{id}';
    public static string | null $resource = SolutionResource::class;


    /**
     * Show Solution
     *
     * @param Request $request
     * @return SolutionTransformer
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

        return new SolutionTransformer($query);
    }
}
