<?php

namespace App\Virtual\Resources;

/**
 * @OA\Schema(
 *  title = "ItensDoPedidoResponseException500",
 *  description = "Resposta enviada via JSON para Lista de Clientes",
 *  @OA\Xml(
 *      name = "ItensDoPedidoResponseException500"
 *  )
 * )
 */
class ItensDoPedidoResponseException500 {
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
     *  title = "categorias",
     *  description = "Lista de Itens do Pedido retornada.",
     * )
     * 
     * @var string
     */
    public $itens;
}