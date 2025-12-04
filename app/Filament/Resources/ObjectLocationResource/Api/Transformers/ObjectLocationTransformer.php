<?php
namespace App\Filament\Resources\ObjectLocationResource\Api\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\ObjectLocation;

/**
 * @property ObjectLocation $resource
 */
class ObjectLocationTransformer extends JsonResource
{

    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return $this->resource->toArray();
    }
}
