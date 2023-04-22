<?php

namespace App\Virtual\Resources;

/**
 * @OA\Schema(
 *  title = "MarcaResponseException406",
 *  description = "Resposta enviada via JSON para os dados de uma Marca",
 *  @OA\Xml(
 *      name = "MarcaResponseException406"
 *  )
 * )
 */
class MarcaResponseException406 {
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
     *  title = "Marca",
     *  description = "Dados de uma Marca.",
     * )
     * 
     * @var string
     */
    public $marca;
}