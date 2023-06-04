<?php

namespace App\Virtual\Resources;

/**
 * @OA\Schema(
 *  title = "CategoriaResponseException406",
 *  description = "Resposta enviada via JSON para os dados de uma Categoria",
 *  @OA\Xml(
 *      name = "CategoriaResponseException406"
 *  )
 * )
 */
class CategoriaResponseException406 {
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
     *  title = "categoria",
     *  description = "Dados de uma categoria.",
     * )
     * 
     * @var string
     */
    public $categoria;
}