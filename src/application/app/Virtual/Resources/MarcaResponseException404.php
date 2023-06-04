<?php

namespace App\Virtual\Resources;

/**
 * @OA\Schema(
 *  title = "MarcaResponseException404",
 *  description = "Resposta enviada via JSON para os dados de uma Marca",
 *  @OA\Xml(
 *      name = "MarcaResponseException404"
 *  )
 * )
 */
class MarcaResponseException404 {
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
     *  example = "Marca não encontrada."
     * )
     * 
     * @var string
     */
    public $mensagem;

    /**
     * @OA\Property(
     *  title = "Marca",
     *  description = "Dados de uma Marca.",
     * )
     * 
     * @var string
     */
    public $marca;
}