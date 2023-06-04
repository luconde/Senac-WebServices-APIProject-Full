<?php

namespace App\Virtual\Resources;

/**
 * @OA\Schema(
 *  title = "ClienteResponseException404",
 *  description = "Resposta enviada via JSON para os dados de um Cliente",
 *  @OA\Xml(
 *      name = "ClienteResponseException404"
 *  )
 * )
 */
class ClienteResponseException404 {
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
     *  example = "Cliente não encontrado."
     * )
     * 
     * @var string
     */
    public $mensagem;

    /**
     * @OA\Property(
     *  title = "cliente",
     *  description = "Dados de uma cliente.",
     * )
     * 
     * @var string
     */
    public $cliente;
}