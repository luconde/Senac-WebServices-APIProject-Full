<?php

namespace App\Virtual\Resources;

/**
 * @OA\Schema(
 *  title = "CategoriaResponse",
 *  description = "Resposta enviada via JSON para os dados de uma Categoria",
 *  @OA\Xml(
 *      name = "CategoriaResponse"
 *  )
 * )
 */
class CategoriaResponse {
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
     *  example = "Categoria retornada."
     * )
     * 
     * @var string
     */
    public $mensagem;

    /**
     * @OA\Property(
     *  title = "categoria",
     *  description = "Dados de uma categoria",
     * )
     * 
     * @var \App\Virtual\Models\Categoria
     */
    public $categoria;
}