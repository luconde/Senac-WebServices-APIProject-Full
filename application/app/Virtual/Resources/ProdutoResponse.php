<?php

namespace App\Virtual\Resources;

/**
 * @OA\Schema(
 *  title = "ProdutoResponse",
 *  description = "Resposta enviada via JSON para os dados de um Produto",
 *  @OA\Xml(
 *      name = "ProdutoResponse"
 *  )
 * )
 */
class ProdutoResponse {
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
     *  example = "Produto retornado."
     * )
     * 
     * @var string
     */
    public $mensagem;

    /**
     * @OA\Property(
     *  title = "produto",
     *  description = "Dados de um produto",
     * )
     * 
     * @var \App\Virtual\Models\Produto
     */
    public $produto;
}