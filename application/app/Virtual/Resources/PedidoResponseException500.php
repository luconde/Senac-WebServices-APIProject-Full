<?php

namespace App\Virtual\Resources;

/**
 * @OA\Schema(
 *  title = "PedidoResponseException500",
 *  description = "Resposta enviada via JSON para os dados de um Pedido",
 *  @OA\Xml(
 *      name = "PedidoResponseException500"
 *  )
 * )
 */
class PedidoResponseException500 {
    /**
     * @OA\Property(
     *  title = "status",
     *  description = "HTTP Status.",
     *  format = "int64",
     *  example = 500
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
     *  example = "Erro interno."
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