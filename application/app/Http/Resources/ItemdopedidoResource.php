<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ItemdopedidoResource extends JsonResource
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
            'id' => $this->pkitemdopedido,
            'quantidade' => $this->quantidade,
            'preco' => $this->precodelista,
            'moeda' => 'USD', // Apenas para efeito de exemplos
            'desconto' => $this->desconto,
            'produto' => new ProdutoResource($this->produto)
        ];
    }
}
