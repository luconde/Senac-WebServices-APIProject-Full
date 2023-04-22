<?php

namespace App\Virtual\Resources;

/**
 * @OA\Schema(
 *  title = "ProdutoResponseException500",
 *  description = "Resposta enviada via JSON para Lista de Produtos",
 *  @OA\Xml(
 *      name = "ProdutoResponseException500"
 *  )
 * )
 */
class ProdutoResponseException500 {
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
     *  description = "Lista de Produtos retornada.",
     * )
     * 
     * @var string
     */
    public $produto;
}