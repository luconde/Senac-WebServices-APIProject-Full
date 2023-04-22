<?php

namespace App\Virtual\Resources;

/**
 * @OA\Schema(
 *  title = "PedidosResponseException500",
 *  description = "Resposta enviada via JSON para Lista de Pedidos",
 *  @OA\Xml(
 *      name = "PedidosResponseException500"
 *  )
 * )
 */
class PedidosResponseException500 {
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
     *  example = "Erro Interno."
     * )
     * 
     * @var string
     */
    public $mensagem;

    /**
     * @OA\Property(
     *  title = "produtos",
     *  description = "Lista de Pedidos retornada.",
     * )
     * 
     * @var string
     */
    public $pedidos;
}