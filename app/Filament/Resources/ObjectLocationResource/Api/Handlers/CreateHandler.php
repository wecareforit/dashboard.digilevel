<?php
namespace App\Filament\Resources\ObjectLocationResource\Api\Handlers;

use Illuminate\Http\Request;
use Rupadana\ApiService\Http\Handlers;
use App\Filament\Resources\ObjectLocationResource;
use App\Filament\Resources\ObjectLocationResource\Api\Requests\CreateObjectLocationRequest;

class CreateHandler extends Handlers {
    public static string | null $uri = '/';
    public static string | null $resource = ObjectLocationResource::class;

    public static function getMethod()
    {
        return Handlers::POST;
    }

    public static function getModel() {
        return static::$resource::getModel();
    }

    /**
     * Create ObjectLocation
     *
     * @param CreateObjectLocationRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function handler(CreateObjectLocationRequest $request)
    {
        $model = new (static::getModel());

        $model->fill($request->all());

        $model->save();

        return static::sendSuccessResponse($model, "Successfully Create Resource");
    }
}