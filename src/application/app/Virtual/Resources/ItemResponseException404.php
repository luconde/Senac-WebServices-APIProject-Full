<?php

namespace App\Virtual\Resources;

/**
 * @OA\Schema(
 *  title = "ItemResponseException404",
 *  description = "Resposta enviada via JSON para os dados de um Item do Pedido",
 *  @OA\Xml(
 *      name = "ItemResponseException404"
 *  )
 * )
 */
class ItemResponseException404 {
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
     *  example = "Item do Pedido não encontrado."
     * )
     * 
     * @var string
     */
    public $mensagem;

    /**
     * @OA\Property(
     *  title = "item",
     *  description = "Dados de um Item do Pedido.",
     * )
     * 
     * @var string
     */
    public $item;
}