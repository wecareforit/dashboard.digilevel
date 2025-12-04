<?php

namespace App\Media;

use Spatie\MediaLibrary\MediaCollections\Models\Media;
 
use Spatie\MediaLibrary\Support\PathGenerator\PathGenerator;


class CustomPathGenerator implements PathGenerator
{
    public function getPath(Media $media): string
    {
        $model = $media->model;
        $collection = $media->collection_name;

        // Example: store files under /uploads/{collection}/{model_id}/
        return "uploads/{$collection}/{$model->id}/";
    }

    public function getPathForConversions(Media $media): string
    {
        return $this->getPath($media) . 'conversions/';
    }

    public function getPathForResponsiveImages(Media $media): string
    {
        return $this->getPath($media) . 'responsive/';
    }
}