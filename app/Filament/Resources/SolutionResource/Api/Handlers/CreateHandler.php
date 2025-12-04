<?php
namespace App\Filament\Resources\SolutionResource\Api\Handlers;

use Illuminate\Http\Request;
use Rupadana\ApiService\Http\Handlers;
use App\Filament\Resources\SolutionResource;
use App\Filament\Resources\SolutionResource\Api\Requests\CreateSolutionRequest;

class CreateHandler extends Handlers {
    public static string | null $uri = '/';
    public static string | null $resource = SolutionResource::class;

    public static function getMethod()
    {
        return Handlers::POST;
    }

    public static function getModel() {
        return static::$resource::getModel();
    }

    /**
     * Create Solution
     *
     * @param CreateSolutionRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function handler(CreateSolutionRequest $request)
    {
        $model = new (static::getModel());

        $model->fill($request->all());

        $model->save();

        return static::sendSuccessResponse($model, "Successfully Create Resource");
    }
}