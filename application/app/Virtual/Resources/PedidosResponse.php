<?php

namespace App\Virtual\Resources;

/**
 * @OA\Schema(
 *  title = "PedidosResponse",
 *  description = "Resposta enviada via JSON para Lista de Pedidos",
 *  @OA\Xml(
 *      name = "PedidosResponse"
 *  )
 * )
 */
class PedidosResponse {
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
     *  example = "Lista de pedidos retornada."
     * )
     * 
     * @var string
     */
    public $mensagem;

    /**
     * @OA\Property(
     *  title = "pedidos",
     *  description = "Lista de Pedidos retornada.",
     * )
     * 
     * @var \App\Virtual\Models\Pedido[]
     */
    public $pedidos;
}