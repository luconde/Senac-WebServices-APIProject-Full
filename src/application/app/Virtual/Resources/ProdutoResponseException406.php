<?php

namespace App\Virtual\Resources;

/**
 * @OA\Schema(
 *  title = "ProdutoResponseException406",
 *  description = "Resposta enviada via JSON para Lista de Produtos",
 *  @OA\Xml(
 *      name = "ProdutoResponseException406"
 *  )
 * )
 */
class ProdutoResponseException406 {
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
     *  title = "produtos",
     *  description = "Lista de Produtos retornada.",
     * )
     * 
     * @var string
     */
    public $produto;
}