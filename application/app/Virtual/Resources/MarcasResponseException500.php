<?php

namespace App\Virtual\Resources;

/**
 * @OA\Schema(
 *  title = "MarcasResponseException500",
 *  description = "Resposta enviada via JSON para Lista de Marcas",
 *  @OA\Xml(
 *      name = "MarcasResponseException500"
 *  )
 * )
 */
class MarcasResponseException500 {
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
     *  title = "Marcas",
     *  description = "Lista de Marcas retornada.",
     * )
     * 
     * @var string
     */
    public $Marcas;
}