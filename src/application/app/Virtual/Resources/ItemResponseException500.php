<?php

namespace App\Virtual\Resources;

/**
 * @OA\Schema(
 *  title = "ItemResponseException500",
 *  description = "Resposta enviada via JSON para os dados de um Item do Pedido",
 *  @OA\Xml(
 *      name = "ItemResponseException500"
 *  )
 * )
 */
class ItemResponseException500 {
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
     *  title = "item",
     *  description = "Dados de um Item do Pedido.",
     * )
     * 
     * @var string
     */
    public $item;
}