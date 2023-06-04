<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PedidoResource extends JsonResource
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
            'id' => $this->pkpedido,
            'data_do_pedido' => $this->datadopedido,
            'cliente' => new ClienteResource($this->cliente),
            'itens' => ItemdopedidoResource::collection($this->itensdopedido)
        ];
    }
}
