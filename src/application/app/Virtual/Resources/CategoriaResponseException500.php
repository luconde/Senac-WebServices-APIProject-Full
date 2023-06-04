<?php

namespace App\Virtual\Resources;

/**
 * @OA\Schema(
 *  title = "CategoriaResponseException500",
 *  description = "Resposta enviada via JSON para os dados de uma Categoria",
 *  @OA\Xml(
 *      name = "CategoriaResponseException500"
 *  )
 * )
 */
class CategoriaResponseException500 {
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
     *  title = "categoria",
     *  description = "Dados de uma categoria.",
     * )
     * 
     * @var string
     */
    public $categoria;
}