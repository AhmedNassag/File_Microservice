<?php

namespace App\Resources\File;

use Illuminate\Http\Resources\Json\JsonResource;

class FileResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray($request): array
    {
        return [
            'id'            => $this->id,
            'name'          => $this->name,
            'mediable_type' => $this->mediable_type ?? null,
            'mediable_id'   => $this->mediable_id ?? null,
            'url'           => $this->url ?? null,
        ];
    }
}