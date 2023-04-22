<?php

namespace App\Virtual\Resources;

/**
 * @OA\Schema(
 *  title = "CategoriasResponse",
 *  description = "Resposta enviada via JSON para Lista de Categorias",
 *  @OA\Xml(
 *      name = "CategoriasResponse"
 *  )
 * )
 */
class CategoriasResponse {
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
     *  example = "Lista de categorias retornada."
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
     * @var \App\Virtual\Models\Categoria[]
     */
    public $categorias;
}