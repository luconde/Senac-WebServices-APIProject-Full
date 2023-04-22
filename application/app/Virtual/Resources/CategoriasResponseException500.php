<?php

namespace App\Virtual\Resources;

/**
 * @OA\Schema(
 *  title = "CategoriasResponseException500",
 *  description = "Resposta enviada via JSON para Lista de Categorias",
 *  @OA\Xml(
 *      name = "CategoriasResponseException500"
 *  )
 * )
 */
class CategoriasResponseException500 {
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
     *  title = "categorias",
     *  description = "Lista de Categorias retornada.",
     * )
     * 
     * @var string
     */
    public $categorias;
}