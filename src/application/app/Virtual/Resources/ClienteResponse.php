<?php

namespace App\Virtual\Resources;

/**
 * @OA\Schema(
 *  title = "ClienteResponse",
 *  description = "Resposta enviada via JSON para os dados de um Cliente",
 *  @OA\Xml(
 *      name = "ClienteResponse"
 *  )
 * )
 */
class ClienteResponse {
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
     *  example = "Cliente retornado."
     * )
     * 
     * @var string
     */
    public $mensagem;

    /**
     * @OA\Property(
     *  title = "cliente",
     *  description = "Dados de um cliente",
     * )
     * 
     * @var \App\Virtual\Models\Cliente
     */
    public $cliente;
}