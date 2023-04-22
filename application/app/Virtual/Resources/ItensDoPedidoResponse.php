<?php

namespace App\Virtual\Resources;

/**
 * @OA\Schema(
 *  title = "ItensDoPedidoResponse",
 *  description = "Resposta enviada via JSON para Lista de Itens do Pedido",
 *  @OA\Xml(
 *      name = "ItensDoPedidoResponse"
 *  )
 * )
 */
class ItensDoPedidoResponse {
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
     *  example = "Lista de Itens do Pedido retornada."
     * )
     * 
     * @var string
     */
    public $mensagem;

    /**
     * @OA\Property(
     *  title = "pedidos",
     *  description = "Lista de Itens do Pedido retornada.",
     * )
     * 
     * @var \App\Virtual\Models\Item[]
     */
    public $itens;
}