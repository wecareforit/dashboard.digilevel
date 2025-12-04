<?php
namespace App\Filament\Resources\SolutionResource\Api;

use Rupadana\ApiService\ApiService;
use App\Filament\Resources\SolutionResource;
use Illuminate\Routing\Router;


class SolutionApiService extends ApiService
{
    protected static string | null $resource = SolutionResource::class;

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
