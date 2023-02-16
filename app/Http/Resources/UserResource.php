<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'type' => 'users', 
            'id' => $this->resource->getRouteKey(), 
            'attributes' => [
                'name'      => $this->resource->name, 
                'email'     => $this->resource->email
            ],
            'links' => [
                'self' => route('api.v1.users.show', $this->resource) 
            ]
        ];
    }

    public function toResponse($request)
    {
        return parent::toResponse($request)->withHeaders([
            'Location' => route('api.v1.users.show', $this->resource)
        ]);
    }
}
