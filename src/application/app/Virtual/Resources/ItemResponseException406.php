<?php

namespace App\Virtual\Resources;

/**
 * @OA\Schema(
 *  title = "ItemResponseException406",
 *  description = "Resposta enviada via JSON para os dados de um Item do Pedido",
 *  @OA\Xml(
 *      name = "ItemResponseException406"
 *  )
 * )
 */
class ItemResponseException406 {
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
     *  title = "item",
     *  description = "Dados de um Item do Pedido.",
     * )
     * 
     * @var string
     */
    public $item;
}