<?php

namespace App\Virtual\Resources;

/**
 * @OA\Schema(
 *  title = "MarcasResponse",
 *  description = "Resposta enviada via JSON para Lista de Marcas",
 *  @OA\Xml(
 *      name = "MarcasResponse"
 *  )
 * )
 */
class MarcasResponse {
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
     *  example = "Lista de Marcas retornada."
     * )
     * 
     * @var string
     */
    public $mensagem;

    /**
     * @OA\Property(
     *  title = "Marcas",
     *  description = "Lista de Marcas retornada.",
     * )
     * 
     * @var \App\Virtual\Models\Marca[]
     */
    public $Marcas;
}