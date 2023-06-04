<?php

namespace App\Virtual\Resources;

/**
 * @OA\Schema(
 *  title = "PedidoResponse",
 *  description = "Resposta enviada via JSON para os dados de um Pedido",
 *  @OA\Xml(
 *      name = "PedidoResponse"
 *  )
 * )
 */
class PedidoResponse {
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
     *  example = "Pedido retornado."
     * )
     * 
     * @var string
     */
    public $mensagem;

    /**
     * @OA\Property(
     *  title = "pedido",
     *  description = "Dados de um pedido",
     * )
     * 
     * @var \App\Virtual\Models\Pedido
     */
    public $pedido;
}