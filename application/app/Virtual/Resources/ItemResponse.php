<?php

namespace App\Virtual\Resources;

/**
 * @OA\Schema(
 *  title = "ItemResponse",
 *  description = "Resposta enviada via JSON para os dados de um Item do Pedido",
 *  @OA\Xml(
 *      name = "ItemResponse"
 *  )
 * )
 */
class ItemResponse {
    /**
     * @OA\Property(
     *  title = "status",
     *  description = "HTTP Status.",
     *  format = "int64",
     *  example = 200
     * )
     * 
     * @var integer
     */
    public $status;

    /**
     * @OA\Property(
     *  title = "mensagem",
     *  description = "Mensagem informativa da resposta.",
     *  format = "string",
     *  example = "Item do Pedido retornado."
     * )
     * 
     * @var string
     */
    public $mensagem;

    /**
     * @OA\Property(
     *  title = "item",
     *  description = "Dados de um Item do Pedido",
     * )
     * 
     * @var \App\Virtual\Models\Item
     */
    public $item;
}