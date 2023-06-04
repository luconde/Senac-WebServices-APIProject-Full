<?php

namespace App\Virtual\Resources;

/**
 * @OA\Schema(
 *  title = "ProdutosResponse",
 *  description = "Resposta enviada via JSON para Lista de Produtos",
 *  @OA\Xml(
 *      name = "ProdutosResponse"
 *  )
 * )
 */
class ProdutosResponse {
    /**
     * @OA\Property(
     *  title = "status",
     *  description = "HTTP Status.",
     *  format = "int64",
     *  example = 200
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
     *  example = "Lista de produtos retornada."
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
     * @var \App\Virtual\Models\Produto[]
     */
    public $produtos;
}