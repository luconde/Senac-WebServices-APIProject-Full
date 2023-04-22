<?php

namespace App\Virtual\Resources;

/**
 * @OA\Schema(
 *  title = "ClienteResponseException500",
 *  description = "Resposta enviada via JSON para os dados de um Cliente",
 *  @OA\Xml(
 *      name = "ClienteResponseException500"
 *  )
 * )
 */
class ClienteResponseException500 {
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
     *  example = "Erro interno."
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