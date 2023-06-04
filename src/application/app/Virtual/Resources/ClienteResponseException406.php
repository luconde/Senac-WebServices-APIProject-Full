<?php

namespace App\Virtual\Resources;

/**
 * @OA\Schema(
 *  title = "ClienteResponseException406",
 *  description = "Resposta enviada via JSON para os dados de um Cliente",
 *  @OA\Xml(
 *      name = "ClienteResponseException406"
 *  )
 * )
 */
class ClienteResponseException406 {
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
     *  title = "cliente",
     *  description = "Dados de um cliente.",
     * )
     * 
     * @var string
     */
    public $cliente;
}