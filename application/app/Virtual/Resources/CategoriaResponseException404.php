<?php

namespace App\Virtual\Resources;

/**
 * @OA\Schema(
 *  title = "CategoriaResponseException404",
 *  description = "Resposta enviada via JSON para os dados de uma Categoria",
 *  @OA\Xml(
 *      name = "CategoriaResponseException404"
 *  )
 * )
 */
class CategoriaResponseException404 {
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
     *  example = "Categoria não encontrada."
     * )
     * 
     * @var string
     */
    public $mensagem;

    /**
     * @OA\Property(
     *  title = "categoria",
     *  description = "Dados de uma categoria.",
     * )
     * 
     * @var string
     */
    public $categoria;
}