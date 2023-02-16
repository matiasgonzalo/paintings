<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PaintingResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request) :array
    {
        return [
            'type' => 'paintings',
            'id' => $this->resource->getRouteKey(),
            'attributes' => array_filter([
                'code'      => $this->resource->code, 
                'name'      => $this->resource->name, 
                'painter'   => $this->resource->painter, 
                'country'   => $this->resource->country, 
                'date'      => $this->resource->date, 
                'style'     => $this->resource->style, 
                'width'     => $this->resource->width, 
                'hight'     => $this->resource->hight
            ]),
            'links' => [
                'self' => route('api.v1.paintings.show', $this->resource)
            ]
        ];
    }

    public function toResponse($request)
    {
        return parent::toResponse($request)->withHeaders([
            'Location' => route('api.v1.paintings.show', $this->resource)
        ]);
    }
}
