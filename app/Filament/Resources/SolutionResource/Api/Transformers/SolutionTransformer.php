<?php
namespace App\Filament\Resources\SolutionResource\Api\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\Solution;

/**
 * @property Solution $resource
 */
class SolutionTransformer extends JsonResource
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
