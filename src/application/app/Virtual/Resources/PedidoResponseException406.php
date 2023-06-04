<?php

namespace App\Virtual\Resources;

/**
 * @OA\Schema(
 *  title = "PedidoResponseException406",
 *  description = "Resposta enviada via JSON para os dados de um Pedido",
 *  @OA\Xml(
 *      name = "PedidoResponseException406"
 *  )
 * )
 */
class PedidoResponseException406 {
    /**
     * @OA\Property(
     *  title = "status",
     *  description = "HTTP Status.",
     *  format = "int64",
     *  example = 406
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
     *  example = "O campo Id deve ser numérico."
     * )
     * 
     * @var string
     */
    public $mensagem;

    /**
     * @OA\Property(
     *  title = "cliente",
     *  description = "Dados de um Pedido.",
     * )
     * 
     * @var string
     */
    public $pedido;
}