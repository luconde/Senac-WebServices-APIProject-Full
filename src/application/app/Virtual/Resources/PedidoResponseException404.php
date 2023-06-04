<?php

namespace App\Virtual\Resources;

/**
 * @OA\Schema(
 *  title = "PedidoResponseException404",
 *  description = "Resposta enviada via JSON para os dados de um Pedido",
 *  @OA\Xml(
 *      name = "PedidoResponseException404"
 *  )
 * )
 */
class PedidoResponseException404 {
    /**
     * @OA\Property(
     *  title = "status",
     *  description = "HTTP Status.",
     *  format = "int64",
     *  example = 404
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
     *  example = "Pedido não encontrado."
     * )
     * 
     * @var string
     */
    public $mensagem;

    /**
     * @OA\Property(
     *  title = "pedido",
     *  description = "Dados de um pedido.",
     * )
     * 
     * @var string
     */
    public $pedido;
}