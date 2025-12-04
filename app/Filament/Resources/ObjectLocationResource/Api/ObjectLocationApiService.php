<?php
namespace App\Filament\Resources\ObjectLocationResource\Api;

use Rupadana\ApiService\ApiService;
use App\Filament\Resources\ObjectLocationResource;
use Illuminate\Routing\Router;


class ObjectLocationApiService extends ApiService
{
    protected static string | null $resource = ObjectLocationResource::class;

    public static function handlers() : array
    {
        return [
            Handlers\CreateHandler::class,
            Handlers\UpdateHandler::class,
            Handlers\DeleteHandler::class,
            Handlers\PaginationHandler::class,
            Handlers\DetailHandler::class
        ];

    }
}
