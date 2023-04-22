<?php

namespace App\Virtual\Resources;

/**
 * @OA\Schema(
 *  title = "MarcaResponse",
 *  description = "Resposta enviada via JSON para os dados de uma Marca",
 *  @OA\Xml(
 *      name = "MarcaResponse"
 *  )
 * )
 */
class MarcaResponse {
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
     *  example = "Marca retornada."
     * )
     * 
     * @var string
     */
    public $mensagem;

    /**
     * @OA\Property(
     *  title = "Marca",
     *  description = "Dados de uma Marca",
     * )
     * 
     * @var \App\Virtual\Models\Marca
     */
    public $marca;
}