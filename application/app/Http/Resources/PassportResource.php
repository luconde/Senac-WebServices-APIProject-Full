<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PassportResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        // Mantido para documentação
        // return parent::toArray($request);

        return [
            'id' => $this->id,
            'nome' => $this->name,
            'email' => $this->email
        ];
    }
}
