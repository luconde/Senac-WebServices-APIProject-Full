<?php

namespace App\Virtual\Resources;

/**
 * @OA\Schema(
 *  title = "MarcaResponseException500",
 *  description = "Resposta enviada via JSON para os dados de uma Marca",
 *  @OA\Xml(
 *      name = "MarcaResponseException500"
 *  )
 * )
 */
class MarcaResponseException500 {
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
     *  title = "Marca",
     *  description = "Dados de uma Marca.",
     * )
     * 
     * @var string
     */
    public $marca;
}