<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class IraResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
        'Tema' => $this->Tema,
        'descripcion' => $this->descripcion,
        'video' => $this->video,
    ];
    }
}
